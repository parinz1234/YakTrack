@extends('layouts.app')

@section('title')
    Sessions
@endsection

@section('subtitle')
@endsection

@section('breadcrumbs')
    {!! Breadcrumbs::render('session.index') !!}
@endsection

@section('content')

@include('partials.modals.delete_item_modal')

<div class="card item-type-container" data-item-type="session">
    <div class="card-header with-border">
        <div class="pull-right">
            <a href="{{ route('session.start') }}" class="btn btn-success btn-sm">
                <i class="fa fa-clock"></i>
                Start Session
            </a>
            <a href="{{ route('session.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i>
                Create Session
            </a>
        </div>
    </div>
    @if($days->count())
        <table class="table card-body">
            <thead>
                <tr>
                    <th> Start Time </th>
                    <th> End Time </th>
                    <th> Total Time </th>
                    <th> Task </th>
                    <th> Comment </th>
                    @foreach($thirdPartyApplications as $app)
                        <th> Linked to {{ $app->name }} </th>
                    @endforeach
                    <th> <span class="pull-right"> Actions </span> </th>
                </tr>
            </thead>
            <tbody>
                @foreach($days as $sessionsInDay)
                    <tr class="active">
                        <td colspan="10"><small class="text-uppercase"> {{ $sessionsInDay->first()->localStartedAt->format('l jS F Y') }} </small></td>
                    </tr>
                    @foreach($sessionsInDay as $session)
                        <tr
                            class="item-container"
                            data-item-name="{{ $session->name }}"
                            data-item-destroy-route="{{ route('session.destroy', ['session' => $session]) }}"
                        >
                            <td>
                                {{ $session->localStartedAtTimeForHumans }}
                            </td>
                            <td>
                                @if ($session->isRunning())
                                    <a class="btn btn-danger" href="{{ route('session.stop', ['session' => $session]) }}"> Stop Now </a>
                                @else
                                    {{ $session->localEndedAtTimeForHumans }}
                                @endif
                            </td>
                            <td>
                                {{ $session->durationForHumans }}
                            </td>
                            <td>
                                @include('partials.session.session-task', ['session' => $session])
                            </td>
                            <td>
                                {{ $session->comment }}
                            </td>
                            @foreach($thirdPartyApplications as $app)
                                <td>
                                    @include('partials.session.third-party-application')
                                <td>
                            @endforeach
                            <td>
                                <div class="btn-group pull-right">
                                    <a
                                        href="{{ route('session.edit', ['session' => $session]) }}"
                                        class="btn btn-default"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('session.destroy', $session->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-default delete-item-button">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <div class="card-body">
            You have not created any sessions yet.
        </div>
    @endif
</div>

@endsection
