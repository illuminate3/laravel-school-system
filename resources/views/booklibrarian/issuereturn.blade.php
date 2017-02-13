<fieldset>
    <legend>{{ trans('booklibrarian.user') }}</legend>
    <fieldset class="col-md-6">
        <legend>{{ trans('booklibrarian.info') }}</legend>
        <div class="form-group">
            <label class="control-label" for="name">{{trans('booklibrarian.name')}}</label>
            <div class="controls">
                {{ $user->full_name }}
            </div>
        </div>
    </fieldset>
    <fieldset class="col-md-6">
        <legend>{{ trans('booklibrarian.contact') }}</legend>
        <div class="form-group">
            <label class="control-label" for="email">{{trans('booklibrarian.email')}}</label>
            <div class="controls">
                {{ $user->email }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="address">{{trans('booklibrarian.address')}}</label>

            <div class="controls">
                {{ $user->address }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="phone">{{trans('booklibrarian.phone')}}</label>

            <div class="controls">
                {{ $user->phone }}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="mobile">{{trans('booklibrarian.mobile')}}</label>

            <div class="controls">
                {{ $user->mobile }}
            </div>
        </div>
    </fieldset>
</fieldset>
<fieldset>
    <legend>{{ trans('booklibrarian.issue_books') }}</legend>
    <table id="books" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{trans('book.internal') }}</th>
            <th>{{trans('book.title') }}</th>
            <th>{{trans('book.author') }}</th>
            <th>{{trans('book.issued') }}</th>
            <th>{{trans('table.actions') }}</th>

        </tr>
        </thead>
        <tbody>
            @foreach ($bookuserb as $book)
                    <tr id="book{{$book['id']}}">
                        <td>{{ $book['internal'] }}</td>
                        <td>{{ $book['title'] }}</td>
                        <td>{{ $book['author'] }}</td>
                        <td>{{ $book['book_get_count'] }}</td>
                        <td>
                            <button onclick="returnBook({{$book['id']}})" class="btn btn-primary btn-sm">
                                {{ trans("booklibrarian.return") }}</button>
                        </td>
                    </tr>
            @endforeach
        </tbody>
    </table>
</fieldset>

<fieldset>
    <legend>{{ trans('booklibrarian.reserved') }}</legend>
    <table id="books" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>{{trans('book.internal') }}</th>
            <th>{{trans('book.title') }}</th>
            <th>{{trans('book.author') }}</th>
            <th>{{trans('book.reserved') }}</th>
            <th>{{trans('table.actions') }}</th>

        </tr>
        </thead>
        <tbody>
        @if($user->reserved_books->count()>0)
            @foreach ($user->reserved_books as $book)
                @if(isset($book->book->title))
                    <tr id="book{{$book->id}}">
                        <td>{{ $book->book->internal }}</td>
                        <td>{{ $book->book->title }}</td>
                        <td>{{ $book->book->author }}</td>
                        <td>{{ $book->reserved }}</td>
                        <td>
                            <button onclick="issueBook({{$book->id}})" class="btn btn-success btn-sm">
                                {{ trans("booklibrarian.issue_book") }}</button>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif
        </tbody>
    </table>
</fieldset>

<a href="{{ url($type) }}" class="btn btn-warning">{{trans('table.close')}}</a>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#bookModal">
    {{trans('booklibrarian.add_book')}}
</button>

