@extends('layouts.app')

@section('content')

<x-home/>
<x-category-slider :categories="$categories" />
<x-new/>
<x-sale/>

@endsection
