<template>
    <div class="container">
        <div class="col-md-12 text-center">
            <h2>Create new feed</h2>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3 order-md-1">
                <form class="needs-validation" novalidate="" v-on:submit="saveForm()">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Feed title" value=""
                                   required="" v-model="feed.title">
                            <div class="invalid-feedback">
                                Valid title is required.
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="description">Description</label>
                            <input type="text" class="form-control" id="description" placeholder="Feed description"
                                   value="" required="" v-model="feed.description">
                            <div class="invalid-feedback">
                                Valid description is required.
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" rows="5" placeholder="Feed content"
                                      required="" v-model="feed.content"></textarea>
                            <div class="invalid-feedback">
                                Valid content is required.
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="link">Link</label>
                            <input type="url" class="form-control" id="link" placeholder="Original link" value=""
                                   required="" v-model="feed.link">
                            <div class="invalid-feedback">
                                Valid link is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="published_at">Published at</label>
                            <input type="date" class="form-control" id="published_at" placeholder="" value=""
                                   required="" v-model="feed.published_at">
                            <div class="invalid-feedback">
                                Valid published at is required.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category">Category</label>
                            <select class="custom-select d-block w-100" id="category" required="" v-model="feed.category">
                                <option v-for="category in categories.data" :value="category">{{ category.name }}</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import {post} from '../../helpers/api'
    import {getCategories} from "../../helpers/categories";

    export default {
        data: function () {
            return {
                categories: [],
                feed: {
                    title: '',
                    content: '',
                    description: '',
                    link: '',
                    published_at: '',
                    category: null
                }
            }
        },
        mounted() {
            getCategories().then(response => {
                this.categories = response
            });
        },
        methods: {
            updateCategory: function (e) {
                console.log(e.target.value);
            },
            saveForm() {
                let app = this;
                let newFeed = app.feed;
                post('/api/feeds', newFeed)
                    .then(function (resp) {
                        app.$router.push({path: '/feeds'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your feed");
                    });
            }
        }
    }
</script>