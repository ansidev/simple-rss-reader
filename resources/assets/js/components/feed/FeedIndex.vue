<template>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <router-link :to="{name: 'feedCreate'}" class="btn btn-primary float-left">Create</router-link>
                <div class="dropdown float-right">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="categoryFilter"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-text="selectedCategory">
                    </a>

                    <div class="dropdown-menu" aria-labelledby="categoryFilter">
                        <a class="dropdown-item" :class="{'active': selectedCategory === 'All'}"
                           href="#" @click="filterFeedByCategory('all')">All
                        </a>
                        <a v-for="category in categories.data" class="dropdown-item"
                           :class="{'active': selectedCategory === category.name}"
                           v-bind:category-id="category.id" href="#" @click="filterFeedByCategory(category)">
                            {{ category.name }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row" v-if="currentFeeds.data && currentFeeds.data.length > 0">
                    <feed-list-item v-for="(feed, index) in currentFeeds.data" :data="feed" :key="index" :index="index" @remove-feed="removeFeed"></feed-list-item>
                </div>
                <div class="row" v-else>
                    <div class="col-sm-12">
                        <div class="jumbotron">
                            <p class="lead text-center">You have no feed</p>
                        </div>
                    </div>
                </div>
                <pagination :pagination="currentFeeds" @paginate="getFeeds" :offset="4"></pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import {get} from '../../helpers/api'
    import {getCategories} from "../../helpers/categories"
    import FeedListItem from './FeedListItem'
    import Pagination from '../common/Pagination'

    export default {
        mounted() {
            this.getFeeds();
            getCategories().then(response => {
                this.categories = response
            });
        },
        data: function () {
            return {
                feeds: [],
                currentFeeds: [],
                categories: [],
                selectedCategory: 'All',
                selectedCategoryId: null
            }
        },
        components: {
            FeedListItem,
            Pagination
        },
        methods: {
            getFeeds() {
                let params = {};
                if (typeof this.currentFeeds.current_page !== 'undefined') {
                    params.page = this.currentFeeds.current_page;
                }
                if (this.selectedCategoryId !== null) {
                    params.categoryId = this.selectedCategoryId
                }
                get('/api/feeds', params)
                    .then((response) => {
                        this.feeds = response.data.feeds;
                        this.currentFeeds = Object.assign({}, this.feeds);
                    })
                    .catch(() => {
                        console.log('handle server error from here');
                    });
            },
            filterFeedByCategory(category) {
                if (category === 'all') {
                    this.selectedCategory = 'All';
                    this.selectedCategoryId = null;
                } else {
                    this.selectedCategory = category.name;
                    this.selectedCategoryId = category.id;
                }
                this.currentFeeds.current_page = 1;
                this.getFeeds();
            },
            removeFeed: function(index) {
                this.currentFeeds.data.splice(index, 1);
            }
        },
    }
</script>
