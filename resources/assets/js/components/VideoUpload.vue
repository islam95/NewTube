<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Upload</div>

                    <div class="panel-body">

                        <input type="file" name="video" id="video" @change="fileInputChange" v-if="!uploading">

                        <div id="video-form" v-if="uploading && !failed">
                            Form
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return {
              uniqueId: null,
              uploading: false,
              uploadingComplete: false,
              failed: false,
              title: 'Untitled',
              description: null,
              visibility: 'private'
          }
        },
        methods: {
            fileInputChange(){
                this.uploading = true;
                this.failed = false;

                this.file = document.getElementById('video').files[0];

                // store the metadata
                this.store().then(() => {
                    // upload the video
                })
                // upload video
            },
            store(){
                return this.$http.post('/videos', {
                    title: this.title,
                    description: this.description,
                    visibility: this.visibility,
                    extension: this.file.name.split('.').pop()
                }).then((response) => {
                    this.uniqueId = response.json().data.uniqueId;
                    });
            }
        },
        mounted() {
            //
        }
    }
</script>
