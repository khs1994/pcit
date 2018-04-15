# 贡献导引

请严格按照以下步骤操作，如有任何问题，请提出 [issue](https://github.com/khs1994-php/khsci/issues/new)

* 在 [GitHub](https://github.com/khs1994-php/khsci/fork) 上点击 `fork` 按钮将本仓库 fork 到自己的仓库，如 `yourname/khsci`，然后 `clone` 到本地。

  ```bash
  $ git clone -b dev git@github.com:yourname/example.git

  $ cd example

  # 将项目与上游关联

  $ git remote add example git@github.com:khs1994-php/khsci.git
  ```

* 增加内容或者修复错误后提交，并推送到自己的仓库。

  ```bash
  $ git add .

  $ git commit -a "Fix issue #1: change helo to hello"

  $ git push origin/dev
  ```

* 在 [GitHub](https://github.com/khs1994-php/khsci) 上提交 `Pull request`，注意请提交到 `dev` 分支。

* 请定期更新自己仓库。

  ```bash
  $ git fetch example

  $ git rebase example/dev

  $ git push -f origin dev
  ```