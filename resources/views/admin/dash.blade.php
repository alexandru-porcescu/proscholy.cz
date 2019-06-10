@extends('layout.admin')

@section('content')
    <div class="content-padding">
        <h1>Administrace</h1>

        <div class="row">
            <div class="col-sm-5">
                <table class="table table-bordered">
                    {{-- <tr>
                        <td>Verze zpěvníku</td>
                        <td><b>Generace #1 - v0.56 (22.3.2019)</b></td>
                    </tr> --}}
                    {{-- <tr>
                        <td>Programátoři</td>
                        <td>Miroslav Šerý, Michael Dojčár, Vít Kološ</td>
                    </tr>
                    <tr>
                        <td>Redakce</td>
                        <td>Matěj, Zuzka, Michal, Mira, Terka, Janey, Barča, Ondra</td>
                    </tr>
                    <tr>
                        <td>Propagace</td>
                        <td>Emma, Peťa, Ben</td>
                    </tr> --}}
                    <tr>
                        <td>Krizový telefon <br>(urgent. dotazy, závady)</td>
                        <td class="text-danger">+420 734 791 909</td>
                    </tr>
                </table>

                <h4 style="margin-top: 40px">Statistika</h4>

                <table class="table table-bordered">
                    <tr>
                        <td>Písně s textem</td>
                        <td><b>{{$songs_w_text_count}}</b></td>
                    </tr>
                    <tr>
                        <td>Písně celkem</td>
                        <td><b>{{$songs_count}}</b></td>
                    </tr>
                    <tr>
                        <td>Autoři</td>
                        <td><b>{{$authors_count}}</b></td>
                    </tr><tr>
                        <td>Externí odkazy</td>
                        <td><b>{{$externals_count}}</b></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-7">
                <h3>Info pro tým</h3>

                <div class="card">
                    <div class="card-header">Hlavní komunikační kanál</div>
                    <div class="card-body">Slack <a href="https://proscholy.slack.com">proscholy.slack.com</a> - lepší
                        je stáhnout si app (mobil/PC)
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Instruktážní videa od Janey</div>
                    <div class="card-body">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/videoseries?list=PLXLfC_XTiu7qWXgsf-18mPu-IWFZ5o2xn" frameborder="0" allow=encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
