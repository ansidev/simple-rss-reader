<template>
    <div class="col-md-6">
        <div class="card flex-md-row mb-4 box-shadow h-md-250 feed-card">
            <div class="card-body d-flex flex-column align-items-start">
                <strong class="d-inline-block mb-2 text-primary">{{ data.category.name }}</strong>
                <h3 class="mb-0">
                    <a class="text-dark" :href="data.link">{{ data.title }}</a>
                </h3>
                <div class="mb-1 text-muted">{{ data.published_at }}</div>
                <p class="card-text mb-auto" v-html="data.description"/>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                        <a class="btn btn-success" :href="data.link" role="button">Read</a>
                        <router-link :to="{name: 'feedEdit', params: {id: data.id}}" class="btn btn-warning" role="button">Edit</router-link>
                        <a class="btn btn-danger" href="#" role="button"
                           v-on:click="deleteFeed(data.id, index)">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {del} from '../../helpers/api'

    export default {
        props: {
            data: {
                required: true
            },
            index: {
                required: true
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        methods: {
            deleteFeed(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    let app = this;
                    del('/api/feeds/' + id)
                        .then(function (response) {
                            app.$emit('remove-feed', index);
                        })
                        .catch(function (response) {
                            console.log(response);
                            alert("Could not delete feed");
                        });
                }
            }
        }
    }
</script>
