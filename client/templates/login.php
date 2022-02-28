<body class="antialiased d-flex flex-column" style="background-image: url('https://i0.wp.com/businessfinder.me/wp-content/uploads/2021/11/2777.jpeg?fit=1900%2C1068&ssl=1')">
    <div class="flex-fill d-flex flex-column justify-content-center py-4">
        <div class="container-tight py-6">
            <form class="card card-md" action="/backend/functions/login.php" method="POST" autocomplete="off">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Войдите в систему</h2>
                        <div class="mb-3">
                            <label class="form-label">Логин</label>
                            <input type="text" class="form-control" id="login" required name="login" placeholder="Ваш Логин">
                        </div>
                    <div class="mb-2">
                        <label class="form-label">
                            Пароль
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" name="password" class="form-control" required id="password" placeholder="Пароль" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Войти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>