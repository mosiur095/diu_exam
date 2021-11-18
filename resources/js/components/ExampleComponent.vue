<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Quice</div>
                    <div class="col-md-1 float-right" style="float: right"><button class="btn-success">Add</button></div>
                    <div class="col-md-12">
                        <form action="/action_page.php">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Version:</label>
                                    <select class="form-control" id="version" @change="select_class">
                                        <option selected="true" disabled>Select one</option>
                                        <option value="1" >Bangla</option>
                                        <option value="2" >English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Class:</label>
                                    <select class="form-control" id="class">
                                        <option selected="true" disabled>Select one</option>
                                        <!-- <div v-for="class in classes">
                                            <option>{{class.name}}</option>
                                        </div> -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Subject:</label>
                                    <select class="form-control" id="subject">
                                        <option selected="true" disabled>Select one</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="email">Common Quize:</label>
                                    <select class="form-control" id="quiz">
                                        <option selected="true" disabled>common quiz</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data() {
            return {
                classes: [],
            }
        },
        methods: {
            select_class(){

                const version = document.getElementById("version").value;
                const versions = { version_name: version };
                axios.get('/selectclass').then(response => {
                    console.log(response.data);

                }).catch(error => {
                    console.log(error);
                })
            }
        },
        mounted() {
            this.classes = this.allclass;
            console.log('Component mounted.');
        }
    }
</script>
