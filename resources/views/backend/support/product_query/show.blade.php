@extends('backend.layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    {{ $query->product != null ? $query->product->getTranslation('name') : translate('Product Not Found') }}
                </h5>
            </div>

            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item px-0">
                        <div class="media mb-2">
                            <img class="avatar avatar-xs mr-3"
                                @if ($query->user != null) src="{{ uploaded_asset($query->user->avatar_original) }}" @endif
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/avatar-place.png') }}';">
                            <div class="media-body">
                                <h6 class="mb-0 fw-600">
                                    @if ($query->user != null)
                                        {{ $query->user->name }}
                                    @endif
                                </h6>
                                <p class="opacity-50">{{ $query->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="font-weight-bold">
                            {{ strip_tags($query->question) }}
                        </p>
                        {{-- <p>
                            {{ strip_tags($query->reply) }}
                        </p> --}}
                    </li>
                </ul>
                @if ((Auth::user()->id == $query->seller_id || Auth::user()->user_type == 'staff') && auth()->user()->can('reply_to_product_queries'))
                    <form action="{{ route('product_query.reply', $query->id) }}" method="POST">
                        @method('put')
                        @csrf
                        <input type="hidden" name="conversation_id" value="{{ $query->id }}">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" rows="4" name="reply" placeholder="{{ translate('Type your reply') }}"
                                    required>{{ $query->reply }}</textarea>
                            </div>
                        </div>
                        <br>
                        <div class="text-right">
                            <button type="submit" class="btn btn-info">{{  $query->reply == null ? translate('Send') : translate('Update') }}</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
