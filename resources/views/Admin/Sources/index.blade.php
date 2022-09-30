<section class="content-header">
    <h1>{{$title}}</h1>
    <a href="{{route('sources.create')}}" class="btn btn-success">Create</a>

</section>
<div class="content">
    <!-- Hover rows -->
    <div class="card">
        <div class="table-responsive">
            
        @if($sources)
            <table class="table table-hover">
                
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sources as $source)
                        <tr>    
                            <td>{{$source->id}}</td>
                            <td>{{$source->title}}</td>
                            <td>
                            <a href="{{route('sources.edit', [$source->id])}}" class="btn btn-primary">Edit</a>
                            <form action="{{route('sources.destroy', [$source->id])}}" method="POST">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <td>
                        </tr>

                    @endforeach
                </tbody>
                
            </table>
        @endif
        </div>
    </div>
</div>