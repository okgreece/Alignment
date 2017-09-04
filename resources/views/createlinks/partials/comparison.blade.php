@if(!empty($candidates))
    @foreach($candidates as $candidate)
    <div class="suggestion">
        <div class="suggestion-label pull-left">
            {{$candidate["label"]}}
        </div>
        <div class="suggestion-button pull-right">
            <button title="@lang('alignment/createlinks.pick-button-title')" class="btn-xs btn-primary"onclick="click_button('{{$candidate["target"]}}')">@lang('alignment/createlinks.pick-button-label')</button>
        </div>
        <div class="suggestion-progress progress progress-{{$candidate["class"]}} pull-right">
            <div class="progress-bar progress-bar-custom progress-bar-{{$candidate["class"]}}" role="progressbar" aria-valuenow="{{round((float)$candidate["score"]*100, 2)}}" aria-valuemin="0" aria-valuemax="100" style="width:{{round((float)$candidate["score"]*100,2)}}%">
               {{round((float)$candidate["score"]*100,2)}}% 
            </div>
        </div>
    </div>
    @endforeach
@else
    @lang('alignment/createlinks.no-scores')
@endif