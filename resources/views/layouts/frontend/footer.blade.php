<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-3">
                <div class="footer-col">
                    <h3>About us</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic nobis fugiat quidem doloribus
                        placeat harum molestiae dolore provident aspernatur accusantium iusto quisquam ducimus
                        expedita voluptas perspiciatis, impedit aliquid odio. Odit.
                    </p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="footer-col">
                    <h3>Pages</h3>
                    @foreach ($pages as $page)
                        <ul>
                            <li>
                                <a href="/page/{{ $page->slug }}">{{ $page->page_title }}</a>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="footer-col">
                    <h3>Quick Links</h3>
                    <ul>
                        <li>
                            <a href="#home">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="footer-col">
                    <h3>Social Pages</h3>
                    <ul>
                        <li>
                            <a href="https://github.com/Poincoin-Token" target="_blank">Github</a>
                        </li>
                        <li>
                            <a href="https://web.facebook.com/Poincoincoin" target="_blank">Facebook</a>
                        </li>
                        <li>
                            <a href="https://t.me/joinchat/1cIjWvGCyjI0ODdl" target="_blank">Telegram</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-white">
                <p class="copyright-text">
                <div class="float-right d-none d-sm-block">
                    version 123
                </div>
                <strong>Copyright &copy; 2022 <a href=" #" class="footer_link">{{ $app_name }}</a></strong>
                </p>
            </div>
        </div>
    </div>
</footer>
