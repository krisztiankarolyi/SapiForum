@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>My Posts</h1>
        <div id="filter_area">
            <input class="form-control" type="text" placeholder="Filter for title or category" id="filterInput" name="filterInput">
        </div>
        <hr>

        <div class="row" id="postsContainer">
            <post-card v-for="post in posts" :key="post.id" :post="post"></post-card>
        </div>
    </div>

    <!-- Többi script és stb. -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Include Vue script -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <!-- Include axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Include your compiled JavaScript file -->
    <script src="{{ mix('js/app.js') }}"></script>
    <script>
        // Define the initial data for the Vue app
        const app = new Vue({
            el: '#postsContainer',
            data: {
                posts: [], // Empty array
            },
            mounted() {
                // Fetch data when the component is mounted
                this.fetchData();
            },
            methods: {
                fetchData() {
                    // Perform AJAX request to fetch data
                    axios.get("{{ route('myPostsFiltered') }}")
                        .then(response => {
                            this.posts = response.data.posts;
                            console.log(this.posts);
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                },
            },
        });
    </script>
@endsection
