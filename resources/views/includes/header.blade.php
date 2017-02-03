    <?php $nav = ["Главная" => "href=/ class='main'",
            "Обо мне" => "href=/#about class='aboutme'",
            "Проекты" => "href=/projects/ class='projects'",
            "Блог" => "href=/blog/ class='blog'"
    ]; ?>
    <nav>
        <ul>

    @foreach($nav as $name =>$link)
                <li>
                    <a {{$link}}>
                        <span></span>
                        {{$name}}
                    </a>
                </li>
    @endforeach

        </ul>
    </nav>
