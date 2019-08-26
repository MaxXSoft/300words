<?php

class DBObject {
  private $dbo;
  private $prefix = 'maxlab_300words_';

  // constructor
  function __construct() {
    $dsn = 'mysql:host=' . __300WORDS_PDO_HOST__;
    $dsn .= ';dbname=' . __300WORDS_PDO_NAME__ . ';charset=utf8mb4';
    $this->dbo = new PDO($dsn, __300WORDS_PDO_USER__, __300WORDS_PDO_PASS__);
  }

  // destructor
  function __destruct() {
    $this->dbo = null;
  }

  // execute an SQL query
  private function querySQL($sql) {
    return $this->dbo->query($sql)->fetchAll();
  }

  // create a new post
  public function newPost($parent, $user, $post) {
    $stmt = $this->dbo->prepare(
      "INSERT INTO `{$this->prefix}posts` (parent, user, post)
              VALUES(:parent, :user, :post)"
    );
    $stmt->bindParam(':parent', $parent,
                     $parent === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
    $stmt->bindParam(':post', $post, PDO::PARAM_STR);
    return $stmt->execute();
  }

  // create a new comment
  public function newComment($postId, $parent, $user, $text) {
    $stmt = $this->dbo->prepare(
      "INSERT INTO `{$this->prefix}comments`
                    (postId, parent, user, text)
              VALUES(:postId, :parent, :user, :text)"
    );
    $stmt->bindParam(':postId', $postId, PDO::PARAM_INT);
    $stmt->bindParam(':parent', $parent,
                     $parent === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
    $stmt->bindParam(':user', $user, PDO::PARAM_STR);
    $stmt->bindParam(':text', $text, PDO::PARAM_STR);
    return $stmt->execute();
  }

  // get post info by id
  public function getPostInfo($id) {
    $stmt = $this->dbo->prepare(
      "SELECT * FROM `{$this->prefix}posts` WHERE id = ?"
    );
    $stmt->execute(array($id));
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result[0];
  }

  // get post path, returns list of post ids
  public function getPostPath($id) {
    $stmt = $this->dbo->prepare('call MaxLab_300words_GetPostPath(?)');
    $stmt->execute(array($id));
    $ret = $stmt->fetchAll();
    $result = array();
    foreach ($ret as $i) {
      $result[] = (int)$i[0];
    }
    return $result;
  }

  // get count of all posts
  public function getPostCount() {
    $result = $this->querySQL(
      "SELECT COUNT(*) FROM `{$this->prefix}posts`"
    );
    return (int)$result[0][0];
  }

  // get list of posts
  public function getPostList($start, $limit) {
    $stmt = $this->dbo->prepare(
      "SELECT * FROM `{$this->prefix}posts` LIMIT :s, :l"
    );
    $stmt->bindParam(':s', $start, PDO::PARAM_INT);
    $stmt->bindParam(':l', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

  // get count of all root posts
  public function getRootPostCount() {
    $result = $this->querySQL(
      "SELECT COUNT(*) FROM `{$this->prefix}posts` WHERE parent IS NULL"
    );
    return (int)$result[0][0];
  }

  // get list of root posts
  public function getRootPostList($start, $limit) {
    $stmt = $this->dbo->prepare(
      "SELECT * FROM `{$this->prefix}posts`
                WHERE parent IS NULL LIMIT :s, :l"
    );
    $stmt->bindParam(':s', $start, PDO::PARAM_INT);
    $stmt->bindParam(':l', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

  // get all child posts count by parent id
  public function getChildPostCount($id) {
    $stmt = $this->dbo->prepare(
      "SELECT COUNT(*) FROM `{$this->prefix}posts` WHERE parent = ?"
    );
    $stmt->execute(array($id));
    $result = $stmt->fetchAll();
    return (int)$result[0][0];
  }

  // get list of all child posts of a parent post by its id
  public function getChildPostList($id, $start, $limit) {
    $stmt = $this->dbo->prepare(
      "SELECT id, post,
              (SELECT COUNT(*) FROM `{$this->prefix}posts`
                               WHERE parent = p.id) AS branchCount,
              (SELECT COUNT(*) FROM `{$this->prefix}comments`
                               WHERE postId = p.id) AS commentCount
          FROM `{$this->prefix}posts` AS p
          WHERE parent = :i LIMIT :s, :l"
    );
    $stmt->bindParam(':i', $id, PDO::PARAM_INT);
    $stmt->bindParam(':s', $start, PDO::PARAM_INT);
    $stmt->bindParam(':l', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

  // get comment count of a post by its id
  public function getCommentCount($postId, $withSubComments = true) {
    $sql = "SELECT COUNT(*) FROM `{$this->prefix}comments` WHERE postId = ?";
    if (!$withSubComments) $sql .= " AND parent IS NULL";
    $stmt = $this->dbo->prepare($sql);
    $stmt->execute(array($postId));
    $result = $stmt->fetchAll();
    return (int)$result[0][0];
  }

  // get all of the comments of a post by its id
  public function getCommentList($postId, $start, $limit) {
    $stmt = $this->dbo->prepare(
      "SELECT *, (SELECT COUNT(*) FROM `{$this->prefix}comments`
                                  WHERE parent = t.id) AS subCount
              FROM `{$this->prefix}comments` AS t
              WHERE postId = :i AND parent IS NULL LIMIT :s, :l"
    );
    $stmt->bindParam(':i', $postId, PDO::PARAM_INT);
    $stmt->bindParam(':s', $start, PDO::PARAM_INT);
    $stmt->bindParam(':l', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

  // get sub comment count of a comment by its id
  public function getSubCommentCount($id) {
    $stmt = $this->dbo->prepare(
      "SELECT COUNT(*) FROM `{$this->prefix}comments` WHERE parent = ?"
    );
    $stmt->execute(array($id));
    $result = $stmt->fetchAll();
    return (int)$result[0][0];
  }

  // get all of the sub comments of a comment by its id
  public function getSubCommentList($id, $start, $limit) {
    $stmt = $this->dbo->prepare(
      "SELECT * FROM `{$this->prefix}comments`
                WHERE parent = :i LIMIT :s, :l"
    );
    $stmt->bindParam(':i', $id, PDO::PARAM_INT);
    $stmt->bindParam(':s', $start, PDO::PARAM_INT);
    $stmt->bindParam(':l', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

}
