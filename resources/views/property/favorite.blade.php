@auth()
    <a   href="#"  title="favorite">
        <i data="{{$id}}" class=" @if($fav) fas @else far @endif fa-heart fa-lg mt-2
            @if(app()->getLocale() == 'en') float-right mr-2 icon-love @else float-left ml-5 @endif">
        </i>
    </a>
@endauth
