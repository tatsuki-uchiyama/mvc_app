<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Casteria</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/login.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
  <div class="main">
    <div class="container-fruid">
      <div class="form-wrapper">
        <h1>ログイン</h1>
        <form action="/user/certification" method="post">
          <p class="error-text">{$errorMessages['auth']|default:''}</p>

          <div class="form-item">
            <label for="email">メールアドレス</label>
            <input type="email" name="email" placeholder="exemple@cin-group.co.jp" value="{$post['email']|default:''}">
            <p class="error-text">{$errorMessages['email']|default:''}</p>
          </div>

          <div class="form-item">
            <label for="password">パスワード</label>
            <input type="password" name="password" placeholder="password" value="{$post['password']|default:''}">
            <p class="error-text">{$errorMessages['password']|default:''}</p>
          </div>

          <div class="button-panel">
            <input type="submit" class="button" value="ログイン"></input>
          </div>

        </form>
        <div class="form-footer">
          <p><a href="/user/sign-up">登録がお済みでない方</a></p>
          <p><a href="#">パスワードをお忘れの方</a></p>
          <p><a href="/">トップページへ</a></p>
        </div>
      </div>
    </div>
  </div>
</body>