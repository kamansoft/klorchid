@component($typeForm, get_defined_vars())
    <div data-controller="relation"
         data-relation-id="{{$id}}"
         data-relation-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-relation-value="{{  $value }}"
         data-relation-model="{{ $relationModel }}"
         data-relation-name="{{ $relationName }}"
         data-relation-key="{{ $relationKey }}"
         data-relation-scope="{{ $relationScope }}"
         data-relation-search-columns="{{ $relationSearchColumns }}"
         data-relation-append="{{ $relationAppend }}"
         data-relation-chunk="{{ $chunk }}"
         data-relation-route="{{ route('platform.systems.relation') }}"
    >
         @if( isset($relationAddRouteName) || isset($relationViewRouteName) || isset($relationEditRouteName)  )
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                @isset($relationAddRouteName)
                    <a href="{{route($relationAddRouteName)}}" class=" btn btn-link">{{__('Add')}}</a>
                @endisset

                @isset($relationEditRouteName)
                    @if (count(json_decode($value))>0)
                        <a href="{{route($relationEditRouteName,json_decode($value)[0]->id)}}"
                           class="btn btn-link">{{__('Edit')}}</a>
                    @endif
                @endisset

                @isset($relationViewRouteName)
                    @if (count(json_decode($value))>0)
                        <a href="{{route($relationViewRouteName,json_decode($value)[0]->id)}}"
                           class="btn btn-link">{{__('View')}}</a>
                    @endif
                @endisset


            </div>
        @endif

        <select id="{{$id}}" data-relation-target="select" {{ $attributes }}>
        </select>
    </div>
@endcomponent
