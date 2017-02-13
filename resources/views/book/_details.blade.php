<div class="panel panel-danger">
    <div class="panel-heading">
        <div class="panel-title"> {{$title}}</div>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <label class="control-label" for="title">{{trans('book.title')}}</label>

            <div class="controls">
                @if (isset($book))
                    {{ $book->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="title">{{trans('book.internal')}}</label>

            <div class="controls">
                @if (isset($book))
                    {{ $book->internal }}
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
        <div class="form-group">
            <label class="control-label" for="author">{{trans('book.author')}}</label>

            <div class="controls">
                @if (isset($book))
                    {{ $book->author }}
                @endif
            </div>
        </div>
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
            <label class="control-label" for="subject">{{trans('book.version')}}</label>

            <div class="controls">
                @if (isset($book))
                    {{ $book->version }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('book.publisher')}}</label>

            <div class="controls">
                @if (isset($book))
                    {{ $book->publisher }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('book.isbn')}}</label>

            <div class="controls">
                @if (isset($book))
                    {{ $book->isbn }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('book.option_id_category')}}</label>

            <div class="controls">
                @if (isset($book->category))
                    {{ $book->category->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('book.option_id_borrowing_period')}}</label>

            <div class="controls">
                @if (isset($book->borrowingPeriod))
                    {{ $book->borrowingPeriod->title }}
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="control-label" for="subject">{{trans('book.currently_issue')}}</label>
            <div class="controls">
                @if (!empty($issued))
                    <ul>
                        @foreach($issued as $item)
                            <li>{{$item->user->full_name}} - {{$item->get_date}} ({{$item->get_books_count}})</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>


        <div class="form-group">
            <div class="controls">
                @if (@$action == 'show')
                    <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.close')}}</a>
                @else
                    <a href="{{ url($type) }}" class="btn btn-primary">{{trans('table.cancel')}}</a>
                    <button type="submit" class="btn btn-danger">{{trans('table.delete')}}</button>
                @endif
            </div>
        </div>
    </div>
</div>