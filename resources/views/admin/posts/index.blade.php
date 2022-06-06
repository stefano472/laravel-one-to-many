@extends('layouts.dashboard')



@section('content')
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-12 ">
                <div class="allPosts d-flex justify-content-between align-items-center">
                    <h1>All Posts</h1>
                    <a href="{{route('admin.posts.create')}}" class="btn btn-info"> 
                        Add new Post
                    </a>
                </div>

                {{-- Creo una tabella --}}
                <table class="table">
                    <thead>
                        {{-- Table title  --}}
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Category</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        {{--/ Table title  --}}
                    </thead>
                    <tbody>
                        {{-- Table content  --}}
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->slug }}</td>
                                <td>
                                    {{-- riguarda spiegazione in in postcontroller function show --}}
                                    {{-- @foreach ($categories as $category)
                                        @if ($category->id === $post->category_id) 
                                            {{ $category->name }}
                                        @endif
                                    @endforeach --}}
                                    {{ $post->category->name }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.posts.show' , $post->id) }}" 
                                        class="btn btn-outline-secondary text-decoration-none" 
                                        > 
                                        Show
                                    </a>
                                    <a href="{{ route('admin.posts.edit' , $post->id) }}" 
                                        class="btn btn-outline-info text-decoration-none" 
                                        > 
                                        Edit
                                    </a>
                                    <a href="{{ route('admin.posts.show', $post->id) }}"
                                        class="text-decoration-none">
                                        <form action="{{route('admin.posts.destroy' ,  $post->id)}}" method="POST" class="d-inline-block ">
                                            @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger" 
                                                    onclick="return confirm('Are you sure you wanna delete the Post?')"
                                                >
                                                    Delete
                                                </button>
                                        </form>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        {{--/ Table content  --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection