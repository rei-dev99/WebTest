## ER図(mermaid)

```mermaid
erDiagram
  user ||--|| status : "ユーザーはステータスを持つ"
  user ||--|| profile : "ユーザーはプロフィールを持つ"
  user ||--o{ post : "ユーザーは投稿を複数持つ"
  user ||--o{ stamp : "ユーザーはスタンプを複数持つ"
  user ||--o{ comment : "ユーザーは他ユーザーの投稿に複数コメントできる"
  user ||--o{ post_stamp : "ユーザーは他ユーザーの投稿に1つスタンプを押せる"
  user ||--o{ comment_stamp : "ユーザーは返信に1つスタンプを押せる"

  profile ||--|{ email : "プロフィールはメールアドレスを複数持つ"

  tag ||--o{ post_tag : "タグは複数の投稿を持つ"

  post ||--o{ post_tag : "投稿は複数のタグを持つ"
  post ||--o{ post_stamp : "投稿は複数のスタンプを選択できる"
  post ||--o{ comment : "コメントは1つの投稿に複数可能"

  stamp ||--o{ post_stamp : "スタンプを投稿で使用する"
  stamp ||--o{ comment_stamp : "スタンプを返信で使用する"

  comment ||--o{ comment_stamp : "返信に1つスタンプをつける"

  user {
    bigint id PK
    timestamp created_at
  }

  status {
    bigint id PK
    bigint user_id FK
    enum status
    timestamp last_login_at
    timestamp deleted_at
  }

  profile {
    bigint id PK
    bigint user_id FK
    string name
    string account_name
    timestamp created_at
  }

  email {
    bigint id PK
    bigint profile_id FK
    string email
    timestamp created_at
  }

  post {
    bigint id PK
    bigint user_id FK
    string content
    timestamp created_at
    timestamp updated_at
  }

  tag {
    bigint id PK
    string name
    timestamp created_at
    timestamp updated_at
  }

  post_tag {
    bigint id PK
    bigint post_id FK
    bigint tag_id FK
  }

  stamp {
    bigint id PK
    bigint user_id FK
    string name
    string stamp_img_path
    timestamp created_at
  }

  comment {
    bigint id PK
    bigint user_id FK
    bigint post_id FK
    string content
    timestamp created_at
    timestamp updated_at
  }

  post_stamp {
    bigint id PK
    bigint user_id FK
    bigint post_id FK
    bigint stamp_id FK
    timestamp created_at
    timestamp updated_at
  }

  comment_stamp {
    bigint id PK
    bigint user_id FK
    bigint comment_id FK
    bigint stamp_id FK
    timestamp created_at
    timestamp updated_at
  }
```

## テーブル定義

テーブル：user
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| created_at | timestamp | NOT NULL |  |  |  |

テーブル：status
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| user_id | bigint | NOT NULL |  |  |  |
| status | enum | NOT NULL |  | "仮登録" |  |
| last_login_at | timestamp |  |  |  |  |
| deleted_at | timestamp | |  |  |  |
enum：{"仮登録", "本登録", "退会済み"}
外部キー制約：user_id に対して、user テーブルの id カラムから設定

テーブル：profile
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| user_id | bigint | NOT NULL |  |  |  |
| name | string | NOT NULL |  |  |  |
| account_name | string | NOT NULL |  |  |  |
| created_at | timestamp | NOT NULL |  |  |  |
ユニークキー制約：account_name カラムに対して設定
外部キー制約：user_id に対して、user テーブルの id カラムから設定

テーブル：email
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| profile_id | bigint | NOT NULL |  |  |  |
| email | string | NOT NULL |  | | |
| created_at | timestamp | NOT NULL |  |  |  |
ユニークキー制約：email カラムに対して設定
外部キー制約：profile_id に対して、profile テーブルの id カラムから設定

テーブル：post
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| user_id | bigint | NOT NULL |  |  |  |
| content | text | NOT NULL |  |  |  |
| created_at | timestamp | NOT NULL |  |  |  |
| updated_at | timestamp | NOT NULL |  |  |  |
外部キー制約：user_id に対して、user テーブルの id カラムから設定

テーブル：tag
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| name | string | NOT NULL |  |  |  |
| created_at | timestamp | NOT NULL |  |  |  |
| updated_at | timestamp | NOT NULL |  |  |  |

テーブル：post_tag
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| post_id | bigint | NOT NULL |  |  |  |
| tag_id | bigint | NOT NULL |  |  |  |
外部キー制約：post_id に対して、post テーブルの id カラムから設定
外部キー制約：tag_id に対して、tag テーブルの id カラムから設定

テーブル：stamp
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| user_id | bigint | NOT NULL |  |  |  |
| name | string | NOT NULL |  |  |  |
| stamp_img_path | string | NOT NULL |  |  |  |
| created_at | timestamp | NOT NULL |  |  |  |
外部キー制約：user_id に対して、user テーブルの id カラムから設定

テーブル：comment
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| user_id | bigint | NOT NULL |  |  |  |
| post_id | bigint | NOT NULL |  |  |  |
| content | string | NOT NULL |  |  |  |
| created_at | timestamp | NOT NULL |  |  |  |
| updated_at | timestamp | NOT NULL |  |  |  |
外部キー制約：user_id に対して、user テーブルの id カラムから設定
外部キー制約：post_id に対して、post テーブルの id カラムから設定

テーブル：post_stamp
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| user_id | bigint | NOT NULL |  |  |  |
| post_id | bigint | NOT NULL |  |  |  |
| stamp_id | bigint | NOT NULL |  |  |  |
| created_at | timestamp | NOT NULL |  |  |  |
| updated_at | timestamp | NOT NULL |  |  |  |
外部キー制約：user_id に対して、user テーブルの id カラムから設定
外部キー制約：post_id に対して、post テーブルの id カラムから設定
外部キー制約：stamp_id に対して、stamp テーブルの id カラムから設定

テーブル：comment_stamp
| カラム名 | データ型 | NULL | キー | 初期値 | AUTO INCREMENT |
| ---- | ---- | ---- | ---- | ---- | ---- |
| id | bigint | NOT NULL | PRIMARY | | YES |
| user_id | bigint | NOT NULL |  |  |  |
| comment_id | bigint | NOT NULL |  |  |  |
| stamp_id | bigint | NOT NULL |  |  |  |
| created_at | timestamp | NOT NULL |  |  |  |
| updated_at | timestamp | NOT NULL |  |  |  |
外部キー制約：user_id に対して、user テーブルの id カラムから設定
外部キー制約：comment_id に対して、comment テーブルの id カラムから設定
外部キー制約：stamp_id に対して、stamp テーブルの id カラムから設定
