@extends('layout.admin')

@section('content-withmenu')
    <div class="__container-fluid">
        <div class="row">
            <div class="col-md-6">
                @if ($error === 'locked')
                    <h2>Je třeba chvilku počkat..</h2>
                    <p>Vypadá to, že píseň {{ $song_lyric->name }} právě upravuje někdo jiný.
                    <br>Abychom předešli možným problémům, tak je píseň dočasně uzamčená.
                    <br><br>
                    <a class="btn btn-outline-primary" href="{{ route('admin.song.edit', $song_lyric) }}">ZKUSIT ZNOVU UPRAVIT</a>
                    <br><br>
                    <img src="https://thumbs.gfycat.com/FoolishHonorableArgentinehornedfrog-size_restricted.gif" alt="You shall not pass">
                    </p>
                @else
                    <h2>Musíme to opravit :(</h2>
                    <form action="{{ route('admin.song.resolve_error', $song) }}" method="post">
                        @csrf
                        @if ($error === 'no_original')
                            <p>Ok nemusíme, ale přihodila se nám věc, která vyžaduje jistou pozornost:</p>
                            <p>Vyskytlo se tu pár překladů jedné písničky a žádný z nich není označený jako originál:</p>
                            @foreach ($song->song_lyrics as $song_l)
                                {{ $song_l->name }}<br>
                            @endforeach
                            <br>
                            <p>Není to tak závačná věc a pokud to je úmysl, tak proti gustu žádný dišputát.<br>
                                Každopádně bude fajn, když jedna z písniček bude označena jako originál.</p>
            
                            <select name="song_original" class="form-control">
                                @foreach ($song->song_lyrics as $song_l)
                                    <option value="{{ $song_l->id }}">{{ $song_l->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <button type="input" name="solution" value="choose_original" class="btn btn-outline-info">Označit vybranou píseň jako originál</button>
            
                            <button type="input" name="solution" value="keep" class="btn btn-outline-info">Neprovádět nic</button>
                            <br><br>
                            <img src="http://www.reactiongifs.com/r/umyb.gif" alt="">
                            <br><br>
                            <p>Nebo přidejte novou píseň, která bude označena jako originál výše uvedených písní:</p>

                            <button type="input" name="solution" value="create_original" class="btn btn-outline-info">Vytvořit novou píseň</button>
            
                        @elseif ($error === 'more_originals')
                            <p>Vyskytl se nám tu problém, že bylo označených víc originálů jedné písničky,<br>
                                konkrétně se jedná o následující položky:
                            </p>
                            @foreach ($song->song_lyrics()->where('is_original', 1)->get() as $song_l)
                                {{ $song_l->name }}<br>
                            @endforeach
                            <br>

                            <p>Vyberte prosím jednu píseň, která bude zachována jako originál</p>

                            <select name="song_original" class="form-control">
                                @foreach ($song->song_lyrics()->where('is_original', 1)->get() as $song_l)
                                    <option value="{{ $song_l->id }}">{{ $song_l->name }}</option>
                                @endforeach
                            </select>
                            <br>
                            <button type="input" name="solution" value="choose_original" class="btn btn-outline-info">Označit vybranou píseň jako originál</button>
                        @else
                            {{-- this shouldn't really happen :)  --}}
                            <p>no sám nevím..</p>
                        @endif
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection
