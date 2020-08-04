<template>
    <div>
        <h1>{{title}}</h1>
        <form id="colorForm" @submit.prevent="addColor">
            <input v-model="selectedColor" type="color" name="color" value="#30AF30">
            <button class="btn btn-success">Add</button>
        </form>
        <div v-for="(color, index) in allColors" :key="color.id" :id="index" class="input-group mb-3">
            <label class="form-control" :style="{ backgroundColor: color.hex }">
                <input :id="color.id" type="color" name="color" :value="color.hex" @change="editColor(index, $event.target.value)">
            </label>
            <div class="input-group-append">
                <button @click.prevent="deleteColor(index)" class="btn btn-danger btn-md">Delete</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ColorsComponent",
        data() {
            return {
                title: "Pick a Color",
                selectedColor: null,
                allColors: [{
                    id: 0,
                    red: 0,
                    green: 0,
                    blue: 0,
                    hex: ''
                }]
            }
        },

        created() {
            axios.get('api/color/all').then(response =>  {
               this.allColors = response.data;
            });
        },

        methods: {
            //Add our selected color.
            addColor() {
                if (this.selectedColor) {
                    axios.post('api/color/create', { color: this.selectedColor})
                        .then(response => {
                            if (response.data.success) {
                                this.allColors.push({
                                    id: response.data.id, hex: this.selectedColor
                                })
                            }
                        });
                }
            },

            //Edit color
            editColor(index, newColor){
                let currentColor = this.allColors[index];
                if(newColor !== currentColor.hex) {
                    axios.post('api/color/edit', {id: currentColor.id, color: newColor}).then(response => {
                        this.allColors[index].hex = newColor;
                    })
                }
            },

            //Delete color on server and array.
            deleteColor(index) {
                if(confirm("Are you sure you would like to delete this color?")) {
                    axios.post('api/color/delete', {id: this.allColors[index].id}).then(response => {
                       if (response.data.success) {
                           this.allColors.splice(index, 1);
                       }
                    });
                }
            }
        }
    }
</script>
<style>
    body {
        background-color: #1d2124;
        color: #b0d4f1;
    }
    .input-group input[type="color"] {
        display: none;
    }
</style>
