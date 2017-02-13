<div class="col-md-6">
<div class="form-group">
    <label class="control-label" for="title">{{trans('book.title')}}</label>
    <div class="controls">
        @if (isset($book))
            {{ $book->title }}
        @endif
    </div>
</div>
<div class="form-group">
    <label class="control-label" for="author">{{trans('book.author')}}</label>
    <div class="controls">
        @if (isset($book))
            {{ $book->author }}
        @endif
    </div>
</div>

<div class="form-group">
    <label class="control-label" for="subject">{{trans('book.subject')}}</label>
    <div class="controls">
        @if (isset($book) && $book->subject_id != null)
            {{ $book->subject()->first()->title }}
        @endif
    </div>
</div>
</div>

<div class="col-md-6">
<div class="form-group">
    <label class="control-label" for="year">{{trans('book.year')}}</label>
    <div class="controls">
        @if (isset($book))
            {{ $book->year }}
        @endif
    </div>
</div>
<div class="form-group">
    <label class="control-label" for="quantity">{{trans('book.quantity')}}</label>
    <div class="controls">
        @if (isset($book))
            {{ $book->quantity }}
        @endif
    </div>
</div>
<div class="form-group">
    <label class="control-label" for="available">{{trans('book.available')}}</label>
    <div class="controls">
        @if (isset($book))
            {{ $book->availableCopies() }}
        @endif
    </div>
</div>
</div>

<button onclick="issueBookModal('{{$book->id}}')" class="btn btn-success btn-sm" {{ (isset($book) && $book->availableCopies() < 1) ? 'disabled' : '' }}>
    {{ trans("booklibrarian.issue_book") }}</button>


