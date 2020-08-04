<?php

namespace App\Http\Controllers;

use App\Colors;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ColorsController
 * @package App\Http\Controllers
 */
class ColorsController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function all() {
        return response()->json(Colors::all(), 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request) {

        $request->validate(['color' => 'required|string']); //@todo: Needs regex validation
        $color = $request->get('color');

        // is it Hex?
        if (strpos("#", $color) === false) {
            $hexToRGB = $this->toRGB($color);
            $newColor = Colors::create(['red' => $hexToRGB[0], 'green' => $hexToRGB[1], 'blue' => $hexToRGB[2]]);
            if($newColor) {
                return response()->json(['success' => true, 'id' => $newColor->id], 200);
            }
        }
        return  response()->json(['success' => false], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request) {
        $request->validate([
            'id'    => 'required|int',
            'color' => 'required|string'
        ]);

        $hexToRGB = $this->toRGB($request->color);
        $update   = Colors::find($request->id)->update([
            'red' => $hexToRGB[0], 'green' => $hexToRGB[1], 'blue' => $hexToRGB[2]
        ]);
        return response()->json($update, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request) {
        $request->validate(['id' => 'required|int']);
        $isDeleted = Colors::find((int)$request->get('id'))->delete();
        return response()->json(['success' => $isDeleted], 200);
    }

    /**
     * @todo: Test with shorthand colors (i.e. ff, cc).
     *
     * @param string $hex
     * @return array
     */
    private function toRGB(string $hex) {
        if (strlen($hex) === 4) {
            $rgb = sscanf($hex, "#%1x%1x%1x");
        } else{
            $rgb = sscanf($hex, "#%02x%02x%02x");
        }

        return $rgb;
    }
}
