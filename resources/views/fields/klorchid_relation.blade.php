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
         data-relation-route="{{ route('platform.systems.relation') }}"
    >

        @isset($relationEditRouteName)
            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <a href="{{route($relationEditRouteName)}}" class=" btn btn-link">{{__('Add')}}</a>
                @if (count(json_decode($value))>0)
                    <a href="{{route($relationEditRouteName,json_decode($value)[0]->id)}}"
                       class="btn btn-link">{{__('Edit')}}</a>
                @endif

            </div>
        @endisset

        <select id="{{$id}}" data-relation-target="select" {{ $attributes }}>
        </select>

    </div>
@endcomponent
