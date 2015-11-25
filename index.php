<!-- #### 基本要件(必須)
下記のような売上情報を格納したテーブル`sales`と社員情報を格納したテーブル`members`が存在する。
このとき、サブクエリや関数を用いて次のレコードを求めるようなSQL文を作成し、実行結果を確認せよ。

1. 最大の売上を出した社員の名前
2. 売上の平均以上を達成した社員の名前
3. 30代以下の社員が達成した売上の合計

``` salesテーブル
member_id, sale, month
1 , 75 , 4
2 , 200 , 5
3 , 15 , 6
4 , 700 , 5
5 , 672 , 4
6 , 56 , 8
7 , 231 , 9
8 , 459 , 8
9 , 8 , 7
10 , 120 , 4
売上合計：2,536
売上平均：253.6
```

``` membersテーブル
member_id, name
1 , Tanaka
2 , Sato
3 , Suzuki
4 , Tsuchiya
5 , Yamada
6 , Sasaki
7 , Harada
8 , Takahashi
9 , Nishida
10 , Nakada
```

``` ageテーブル
member_id, age
1 , 24
2 , 25
3 , 47
4 , 55
5 , 39
6 , 26
7 , 43
8 , 33
9 , 24
10 , 20
``` -->
<?php

require_once('functions.php');

$dbh = connectDb();

//1.最大の売上を出した社員の名前の算出
$sql = "select * from members where member_id = (select member_id from sales order by sale desc limit 1)";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($rows[0]['name']);

//2.売上の平均以上を達成した社員の名前の算出
$sql = "SELECT DISTINCT m.name FROM sales AS s INNER JOIN members AS m ON s.member_id = m.member_id WHERE s.sale > (SELECT AVG(sale) FROM sales)";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$avgs = $stmt->fetchAll(PDO::FETCH_ASSOC);
//echo $avgs[0]['name'];

//3.30代以下の社員が達成した売上の合計の算出
$sql = "select sum(sale) from age join sales on age.member_id = sales.member_id where age <= 30";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$salesSum = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($salesSum);


echo "1.最大の売上を出した社員の名前：".$rows[0]['name']."<br>";
echo "2.売上の平均以上を達成した社員の名前：".$avgs[0]['name'].",".$avgs[1]['name'].",".$avgs[2]['name']."<br>";
echo "3.30代以下の社員が達成した売上の合計：".$salesSum[0]['sum(sale)'];



