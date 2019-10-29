<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3" v-if="image">
                <img :src="image" class="img-responsive" height="70" width="90">
            </div>

            <div v-if="success != ''" class="alert alert-success col-md-12" role="alert">
                {{success}}
            </div>


            <form class="col-12 " @submit.prevent="">
                <div class="row">
                    <div class="col-12">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input"  accept="image/*" v-on:change="onImageChange">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <a href="/" class="btn btn-outline-primary btn-lg btn-block mb-3">Back</a>
                    </div>
                    <div class="col-12 col-lg-6">
                        <button type="submit" class="btn btn-outline-success btn-lg btn-block mb-3" @click="uploadImage">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                image: "",
                success: ''
            }
        },
        methods:{
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            uploadImage(){
                let currentObj = this;
                // axios.post('/image/store',{image: this.image}).then(response => {
                //     console.log(response);
                // });

                axios.post('/image/store', {image: this.image})
                    .then(function (response) {
                        currentObj.success = response.data.success;
                    })
                    .catch(function (error) {
                        currentObj.output = error;
                    });
            }
        }
    }
</script>
