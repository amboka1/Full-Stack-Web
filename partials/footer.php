
<footer>
            <div class="footer__socials">
                <a href="https://youtube.com" target="_blank"><i class="uil uil-youtube"></i></a>
                <a href="https://www.facebook.com/profile.php?id=100070075491749" target="_blank"><i class="uil uil-facebook-f"></i></a>
                <a href="https://www.instagram.com/ambokaa/" target="_blank"><i class="uil uil-instagram-alt"></i></a>
                <a href="https://github.com" target="_blank"><i class="uil uil-github"></i></a>
            </div>
            <div class="container footer__container">
                <article>
                    <h4>Categories</h4>
                    <?php 
                    $all_categories_query = "SELECT * FROM categories";
                    $all_categories = mysqli_query($connection, $all_categories_query);
                    ?>
                    <?php while($category = mysqli_fetch_assoc($all_categories)) : ?>
                    <ul>
                        <li><a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>"><?= $category['title'] ?></a></li>
                        </ul>
                        <?php endwhile ?>
                </article>
                <article>
                    <h4>Support</h4>
                    <ul>
                        <li><a href="">Online Support</a></li>
                        <li><a href="">Call Number</a></li>
                        <li><a href="">Emails</a></li>
                        <li><a href="">Social Supports</a></li>
                    </ul>
                </article>
                <article>
                    <h4>Blog</h4>
                    <ul>
                        <li><a href="">Popular</a></li>
                        <li><a href="">Categories</a></li>
                        <li><a href="">Recent</a></li>
                        <li><a href="">Repair</a></li>
                    </ul>
                </article>
                <article>
                    <h4>Permalinks</h4>
                    <ul>
                        <li><a href="">Home</a></li>
                        <li><a href="">Blog</a></li>
                        <li><a href="">About</a></li>
                        <li><a href="">Services</a></li>
                    </ul>
                </article>
            </div>
            <div class="footer__copyright">
                <small>Copyright &copy; 2023 Amboka</small>
            </div>
        </footer>



        <script src="<?= ROOT_URL ?>js/main.js"></script>

</body>
</html>