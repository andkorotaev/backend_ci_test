<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Test Task</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/app.css?v=<?= filemtime(FCPATH . '/css/app.css') ?>">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<body>
<div id="app">
  <div class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
              aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <li class="nav-item">
            <?php  if (User_model::is_logged()): ?>
              <a href="/main_page/logout" class="btn btn-primary my-2 my-sm-0"
                 data-target="#loginModal">Log out, <?= $user->personaname?>
              </a>
            <?php else: ?>
              <button type="button" class="btn btn-success my-2 my-sm-0" type="submit" data-toggle="modal"
                      data-target="#loginModal">Log IN
              </button>
            <?php endif; ?>
        </li>
        <li class="nav-item">
            <?php  if (User_model::is_logged()): ?>
              <button type="button" class="btn btn-success my-2 my-sm-0" type="submit" data-toggle="modal"
                      data-target="#addModal">Add balance
              </button>
            <?php endif;?>
        </li>
          <li class="nav-item">
              <?php  if (User_model::is_logged()): ?>
                  <button type="button" class="btn btn-success my-2 my-sm-0" @click="openBalanceModal">My balance - ${{currentBalance}}
                  </button>
              <?php endif;?>
          </li>

          <li class="nav-item">
              <?php  if (User_model::is_logged()): ?>
                  <button type="button" class="btn btn-success my-2 my-sm-0" @click="openLikesModal">My likes - {{currentLikes}}
                  </button>
              <?php endif;?>
          </li>
      </div>
<!--      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">-->
<!--        <li class="nav-item">-->
<!--            --><?// if (User_model::is_logged()) {?>
<!--              <button type="button" class="btn btn-primary my-2 my-sm-0" type="submit" data-toggle="modal"-->
<!--                      data-target="#loginModal">Log in-->
<!--              </button>-->
<!--            --><?// } else {?>
<!--              <button type="button" class="btn btn-danger my-2 my-sm-0" href="/logout">Log out-->
<!--              </button>-->
<!--            --><?// } ?>
<!--        </li>-->
<!--        <li class="nav-item">-->
<!--          <button type="button" class="btn btn-success my-2 my-sm-0" type="submit" data-toggle="modal"-->
<!--                  data-target="#addModal">Add balance-->
<!--          </button>-->
<!--        </li>-->
<!--      </div>-->
    </nav>
  </div>
  <div class="main">
    <div class="posts">
      <h1 class="text-center">Posts</h1>
      <div class="container">
        <div class="row">
          <div class="col-4" v-for="post in posts" v-if="posts">
            <div class="card">
              <img :src="post.img + '?v=<?= filemtime(FCPATH . '/js/app.js') ?>'" class="card-img-top" alt="Photo">
              <div class="card-body">
                <h5 class="card-title">Post - {{post.id}}</h5>
                <p class="card-text">{{post.text}}</p>
                <button type="button" class="btn btn-outline-success my-2 my-sm-0" @click="openPost(post.id)">Open post
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="boosterpacks">
        <h1 class="text-center">Boosterpack's</h1>
        <div class="container">
          <div class="row">
            <div class="col-4" v-for="box in packs" v-if="packs">
              <div class="card">
                <img :src="'/images/box.png' + '?v=<?= filemtime(FCPATH . '/js/app.js') ?>'" class="card-img-top" alt="Photo">
                <div class="card-body">
                  <button type="button" class="btn btn-outline-success my-2 my-sm-0" @click="buyPack(box.id)">Buy boosterpack {{box.price}}$
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      If You need some help about core - read README.MD in system folder
      <br>
      What we have done All posts: <a href="/main_page/get_all_posts">/main_page/get_all_posts</a> One post: <a
          href="/main_page/get_post/1">/main_page/get_post/1</a>
      <br>
      Just go coding Login: <a href="/main_page/login">/main_page/login</a> Make boosterpack feature <a
          href="/main_page/buy_boosterpack">/main_page/buy_boosterpack</a> Add money feature <a
          href="/main_page/add_money">/main_page/add_money</a>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Log in</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="exampleInputEmail1">Please enter login</label>
              <input type="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" v-model="login" required>
              <div class="invalid-feedback" v-if="invalidLogin">
                Please write a username.
              </div>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Please enter password</label>
              <input type="password" class="form-control" id="inputPassword" v-model="pass" required>
              <div class="invalid-feedback" v-show="invalidPass">
                Please write a password.
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" @click.prevent="logIn">Login</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade bd-example-modal-xl" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true" v-if="post">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Post {{post.id}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="user">
            <div class="avatar"><img :src="post.user.avatarfull" alt="Avatar"></div>
            <div class="name">{{post.user.personaname}}</div>
          </div>
          <div class="card mb-3">
            <div class="post-img" v-bind:style="{ backgroundImage: 'url(' + post.img + ')' }"></div>
            <div class="card-body">
              <div class="likes" @click="addLike(post.id, 'post')">
                <div class="heart-wrap">
                    <div class="heart">
                        <svg class="bi bi-heart" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 01.176-.17C12.72-3.042 23.333 4.867 8 15z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                  <span v-if="post.likes">{{post.likes}}</span>
                </div>
              </div>

                <comment-component :comments="post.coments" :padding="0"></comment-component>

              <form class="form-inline new-comment-form">
                  <div class="form-group">
                      <p v-if="commentTo">To:
                          <a href="#" @click.prevent="scrollToElement('comment-' + commentTo)">
                              #{{commentTo}}
                          </a>
                          <a href="#" class="ml-2" @click.prevent="commentTo = null">Cancel</a>
                      </p>
                  </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="addComment" v-model="commentText">
                </div>
                <button @click.prevent="addComment" type="submit" class="btn btn-primary">Add comment</button>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add money</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="exampleInputEmail1">Enter sum</label>
              <input type="text" class="form-control" id="addBalance" v-model="addSum" required>
              <div class="invalid-feedback" v-if="invalidSum">
                Please write a sum.
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" @click="fiilIn">Add</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="amountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
       aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Amount</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h2 class="text-center">Likes: {{amount}}</h2>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>
    <!-- Modal -->
    <div class="modal fade balance-modal" id="balanceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Balance info</h5>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#transactions">Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#balance">Current balance</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="transactions">
                            <div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Datetime</th>
                                        <th scope="col">Transaction</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="balanceModalTransactions">
                                    <tr v-for="(transaction, key) in balanceModalTransactions">
                                        <th scope="row">{{key+1}}</th>
                                        <td>{{transaction.time_created}}</td>
                                        <td>{{transaction.type}}</td>
                                        <td>{{transaction.type === 'add_money' ? '+' : '-' }}{{transaction.amount}}$</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="balance">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">wallet_balance</th>
                                    <th scope="col">wallet_total_refilled</th>
                                    <th scope="col">wallet_total_withdrawn</th>
                                </tr>
                                </thead>
                                <tbody v-if="balanceModalInfo">
                                <tr>
                                    <td>{{balanceModalInfo.wallet_balance}}$</td>
                                    <td>{{balanceModalInfo.wallet_total_refilled}}$</td>
                                    <td>{{balanceModalInfo.wallet_total_withdrawn}}$</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade likes-modal" id="likesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Likes info</h5>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Datetime</th>
                            <th scope="col">Boosterpack price</th>
                            <th scope="col">Likes</th>
                        </tr>
                        </thead>
                        <tbody v-if="likesModalInfo">
                        <tr v-for="(info, key) in likesModalInfo">
                            <th scope="row">{{key+1}}</th>
                            <td>{{info.time_created}}</td>
                            <td>{{info.price}}$</td>
                            <td>{{info.likes}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/x-template" id="comment-component">
    <div :style="{ 'padding-left': padding + 'px' }">
        <div class="card mb-2" v-for="comment in comments" :class="'comment-' + comment.id">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between text-secondary">
                    <div>{{comment.user.personaname}}</div>
                    <div>#{{comment.id}}</div>
                </div>
                <!--<p v-if="comment.reply_id">To:
                    <a href="#" @click.prevent="scrollToElement('comment-' + comment.reply_id)">
                        #{{comment.reply_id}}
                    </a>
                </p>-->
                <p class="card-text">{{comment.text}}</p>
                <!--<div class="text-secondary" v-if="comment.comments.length">
                    Comments:
                    <a
                            class="mr-2"
                            v-for="com in comment.comments"
                            href="#"
                            @click.prevent="scrollToElement('comment-' + com.id)"
                    >
                        #{{com.id}},
                    </a>
                </div>-->

                <div class="card-title d-flex justify-content-between mt-2">
                    <div class="likes" @click="addLike(comment.id, 'comment')">
                        <div class="heart-wrap">
                            <div class="heart">
                                <svg class="bi bi-heart" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 01.176-.17C12.72-3.042 23.333 4.867 8 15z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <span v-if="comment.likes">{{comment.likes}}</span>
                        </div>
                    </div>
                    <a href="#" @click.prevent="toComment(comment.id)">Comment</a>
                </div>
            </div>

            <comment-component
                    v-if="comment.comments"
                    :comments="comment.comments"
                    :padding="padding + 30"
            >
            </comment-component>
        </div>
    </div>
</script>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
<script src="/js/app.js?v=<?= filemtime(FCPATH . '/js/app.js') ?>"></script>
</body>
</html>


