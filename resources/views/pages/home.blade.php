@extends('layouts.default')
@section('content')
    <main class="bg">
        <h1>Привет, меня зовут Токарев Святослав <br>
            и это моя мастерская.</h1>
        <br>
        <p>Я PHP-программист со знанием front-end технологий.<br>
            Тут Вы сможете найти примеры моих скриптов и сайтов( в том числе, текущий).<br>
            Кроме того в блоге я буду писать статьи на темы, <br>
            связанные с IT, и о том, что мне интересно.<br>
            Данный сайт еще создается, так что не судите строго :).<br>
            Спасибо, что заглянули :)</p>
        <div class="icons">
            <a href="https://github.com/svtokarevsv"><i class="fa fa-github fa-2x" aria-hidden="true"></i></a>
            <a href="https://ua.linkedin.com/in/tokarevsvyatoslav"><i class="fa fa-linkedin fa-2x"
                                                                      aria-hidden="true"></i></a>
            <a href="https://www.facebook.com/svtokarevsv"><i class="fa fa-facebook fa-2x" aria-hidden="true"></i></a>
            <a href="https://plus.google.com/u/1/115678536258450581245"><i class="fa fa-google-plus fa-2x"
                                                                           aria-hidden="true"></i></a>
        </div>
    </main>
    <section class="about" id="about">
        <img src="{{ URL::asset('img/me.png') }}">
        <div class="about_text">
            <h2>Обо мне</h2>
            <p> С раннего детства любил компьютеры, что не могло не отразиться на моих увлечениях.
                <br><br>
                Программирование доставляет мне удовольствие, особенно, если после завершения
                одного приложения, сразу вижу, как можно улучшить прежние и придумать новые.
                <br><br>
                В круг моих интересов сейчас входят HTML, CSS, PHP, MySQL, JS - однако ими я
                себя ограничивать не планирую.<br><br>
                Также работаю на фрилансе в паре с группой профессиональных дизайнеров/аниматоров и веду наш сайт <a
                        href="http://skif.xyz">SKIF Production</a>.<br>Если Вас это заинтересовало, всегда рад ответить на
                вопросы.<br><br>
                Если у Вас есть ко мне предложения или идеи, пишите по адресу: <br><span
                        id="contact">svtokarevsv@gmail.com</span></p>
        </div>
    </section>
@stop
@section('title')Главная@stop