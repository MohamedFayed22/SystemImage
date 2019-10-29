<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an Print component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>




<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3" v-if="image">
                <img :src="image" class="img-responsive" height="70" width="90">
            </div>
            <div v-if="success != ''" class="alert alert-success col-md-12" role="alert">
                {{success}}
            </div>
            <form class="col-12 "  @submit="formSubmit" enctype="multipart/form-data">
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
                        <button type="submit" class="btn btn-outline-success btn-lg btn-block mb-3" >Save</button>
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
                image: '',
                success: ''
            };
        },
        methods:{
            onImageChange(e){
                console.log(e.target.files[0]);
                this.image = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();
                formData.append('image', this.image);

                axios.post('/image/store', formData, config)
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

