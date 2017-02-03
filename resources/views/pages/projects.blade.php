@extends('layouts.default')
@section('content')
    <main>
        <div class="col-xs-12">
            <a href="project/angular" class="btn btn-success">Перейти к проекту</a>
        </div>
        <section class="col-xs-8 col-xs-offset-2">
            <h1 class="big_heading">Проекты</h1>
            <article class="col-xs-12">
                <h2>1. Доска объявлений MyBarter.UA</h2>
                <div class="col-sm-6">
                    <p>Данный проект создан с нуля на чистом PHP.MyBarter - придуманный мной бренд.</p>
                    <p>Написан проект на самописном MVC фреймворке в ООП стиле.</p>
                    <p>Что применялось: </p>
                    <ul>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;PHP</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;ООП</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;PDO+prepared statements</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;MVC+другие паттерны</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;Twitter Bootstrap</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;JavaScript,jQuery</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;MySQL</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;Composer+PSR4 namespacing</li>
                    </ul>
                </div>
                <div class="col-sm-6 ">
                    <img class="project-image" src="{{ URL::asset('img/mybarter.jpg') }}">
                </div>
                <div class="col-xs-12">
                    <a href="project/MyBarter/" class="btn btn-success">Перейти к проекту</a>
                </div>

            </article>
            <article class="col-xs-12">
                <h2>2. Новостной портал MyNews</h2>
                <div class="col-sm-6">
                    <p>Данный проект создан с нуля на чистом PHP.</p>
                    <p>Написан проект на самописном MVC фреймворке в ООП стиле.</p>
                    <p>Что применялось: </p>
                    <ul>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;PHP</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;ООП</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;MVC</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;Twitter Bootstrap</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;JavaScript,jQuery</li>
                        <li><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>&nbsp;MySQL</li>
                    </ul>
                </div>
                <div class="col-sm-6 ">
                    <img class="project-image" src="{{ URL::asset('img/news.jpg') }}">
                </div>
                <div class="col-xs-12">
                    <a href="project/MyNews/" class="btn btn-success">Перейти к проекту</a>
                </div>

            </article>
            <article class="col-xs-12">
                <h2>3. Сайт дизайнерской студии<br>&nbsp;&nbsp;&nbsp; SKIF Production</h2>
                <div class="col-sm-6">
                    <p>Проект оформлен мной на теме CMS WordPress.</p>
                </div>
                <div class="col-sm-6 ">
                    <img class="project-image" src="{{ URL::asset('img/skif.jpg') }}">
                </div>
                <div class="col-xs-12">
                    <a href="http://skif.xyz/" class="btn btn-success">Перейти к проекту</a>
                </div>

            </article>
            <article class="col-xs-12">
                <h2>4. Сайт известного украинского пианиста<br>&nbsp;&nbsp;&nbsp; Алексея Ботвинова</h2>
                <div class="col-sm-6">
                    <p>Проект оформлен мной на теме CMS WordPress. <br/>Однако дальнейшим его наполнением занимался не я, и проект "перегрузили" информацией</p>
                </div>
                <div class="col-sm-6 ">
                    <img class="project-image" src="{{ URL::asset('img/botvinov.jpg') }}">
                </div>
                <div class="col-xs-12">
                    <a href="http://botvinov.com.ua/" class="btn btn-success">Перейти к проекту</a>
                </div>
            </article>
            <article class="col-xs-12">
                <h2>5. Этот сайт - визитка</h2>
                <div class="col-sm-6">
                    <p>Проект оформлен мной с использованием MVC на чистом PHP с нуля</p>
                </div>
                <div class="col-sm-6 ">
                    <img class="project-image" src="{{ URL::asset('img/web-programmer.jpg') }}">
                </div>
                <div class="col-xs-12">
                    <a href="http://web-programmer.xyz/" class="btn btn-success">Перейти к проекту</a>
                </div>
            </article>
        </section>

    </main>
@stop
@section('title')Проекты@stop