-- 類別
CREATE TABLE categories (
  id SERIAL PRIMARY KEY,
  cate_name VARCHAR(100) NOT NULL,
  cate_parent_id INTEGER, --父類別
  cate_level INTEGER DEFAULT 1, --表示該類別的層級
  cate_order INTEGER DEFAULT 0, --排序用
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
  FOREIGN KEY (cate_parent_id) REFERENCES categories (id) ON DELETE SET NULL --當所參照的 cate_parent_id 被刪除時，設置為NULL
);

-- 單字 (主表)
CREATE TABLE words (
  id SERIAL PRIMARY KEY,
  ws_name TEXT NOT NULL, --名稱
  ws_definition TEXT, --定義
  ws_pronunciation TEXT, --發音
  ws_slogan TEXT, --非常簡短的標語、註解(類似關鍵字)
  ws_description TEXT, --註解
  ws_is_important BOOLEAN DEFAULT false, -- 是否重要
  ws_is_common BOOLEAN DEFAULT false, --是否常見
  ws_forget_count INTEGER DEFAULT 0, --忘記次數
  ws_order INTEGER DEFAULT 1, --顯示順序，預設1
  cate_id INTEGER, --categories 外來鍵
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
  FOREIGN KEY (cate_id) REFERENCES categories (id) ON DELETE SET NULL --當所參照的 cate_id 被刪除時，設置為NULL
);

-- 標籤顏色
CREATE TABLE tags_color (
  id SERIAL PRIMARY KEY, 
  tc_color VARCHAR(100) NOT NULL, -- 文字顏色 css
  tc_background	VARCHAR(100) NOT NULL, -- 背景顏色 css
  tc_border VARCHAR(100) NOT NULL, -- 邊框顏色 css
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP NOT NULL DEFAULT NOW()
);

-- 標籤
CREATE TABLE tags (
  id SERIAL PRIMARY KEY,
  ts_name VARCHAR(1000) NOT NULL,
  ts_storage BOOLEAN DEFAULT true, --表示該標籤是否用於存放資料
  ts_parent_id INTEGER, --父標籤
  ts_level INTEGER DEFAULT 1, --表示該標籤的層級
  ts_order INTEGER DEFAULT 1, --表示該標籤在同一層級中的排序順序
  tc_id INTEGER DEFAULT NULL, --外鍵
  ts_description TEXT, --說明或備註
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
  FOREIGN KEY (ts_parent_id) REFERENCES tags (id) ON DELETE SET NULL, --當所參照的 ts_parent_id 被刪除時，設置為NULL
  FOREIGN KEY (tc_id) REFERENCES tags_color(id) ON DELETE SET NULL --當所參照的 tc_id 被刪除時，設置為NULL
);

-- 關聯表 單字-標籤
CREATE TABLE words_tags (
  id SERIAL PRIMARY KEY,
  ts_id INTEGER NOT NULL, -- tags 的主鍵
  ws_id INTEGER NOT NULL, -- words 的主鍵
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
  FOREIGN KEY (ts_id) REFERENCES tags (id) ON DELETE CASCADE, --當所參照的 ts_id 被刪除時，刪除本表所有關聯值
  FOREIGN KEY (ws_id) REFERENCES words (id) ON DELETE CASCADE --當所參照的 ws_id 被刪除時，刪除本表所有關聯值
);

-- 文章
CREATE TABLE articles (
  id SERIAL PRIMARY KEY,
  arti_title VARCHAR(500) NOT NULL,
  arti_content TEXT,
  arti_order INTEGER DEFAULT 1, 
  cate_id INTEGER, -- 關聯外鍵 categories 的主鍵 
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
  FOREIGN KEY (cate_id) REFERENCES categories (id) ON DELETE SET NULL -- 當所參照的 cate_id 被刪除時，將設為NULL
);

-- 關聯表 文章-標籤
CREATE TABLE articles_tags (
  id SERIAL PRIMARY KEY, 
  arti_id INTEGER NOT NULL, 
  ts_id INTEGER NOT NULL, -- tags 的編號
  created_at TIMESTAMP NOT NULL DEFAULT NOW(), 
  updated_at TIMESTAMP NOT NULL DEFAULT NOW(), 
  FOREIGN KEY (arti_id) REFERENCES articles (id) ON DELETE CASCADE, -- 當所參照的 arti_id 被刪除時，刪除本表所有關聯值
  FOREIGN KEY (ts_id) REFERENCES tags (id) ON DELETE CASCADE -- 當所參照的 ts_id 被刪除時，刪除本表所有關聯值
);

-- 關聯表 文章-單字
CREATE TABLE articles_words (
  id SERIAL PRIMARY KEY, 
  arti_id INTEGER NOT NULL, -- articles 的主鍵
  ws_id INTEGER NOT NULL, -- words 的主鍵
  created_at TIMESTAMP NOT NULL DEFAULT NOW(), 
  updated_at TIMESTAMP NOT NULL DEFAULT NOW(), 
  FOREIGN KEY (arti_id) REFERENCES articles (id) ON DELETE CASCADE, -- 當所參照的 arti_id 被刪除時，刪除本表所有關聯值
  FOREIGN KEY (ws_id) REFERENCES words (id) ON DELETE CASCADE -- 當所參照的 ws_id 被刪除時，刪除本表所有關聯值
);

-- 單字群組
CREATE TABLE words_groups (
  id SERIAL PRIMARY KEY, --該表是為了與words關聯所開設的
  wg_name VARCHAR(200) NOT NULL, -- 單字關聯群組名稱
  created_at TIMESTAMP NOT NULL DEFAULT NOW(),
  updated_at TIMESTAMP NOT NULL DEFAULT NOW()
);

-- 關聯表 單字-群組
CREATE TABLE words_groups_details (
  id SERIAL PRIMARY KEY, -- 主鍵
  ws_id INTEGER NOT NULL, -- words 主鍵
  wg_id INTEGER NOT NULL, -- words_groups 主鍵
  wgd_content TEXT, -- 關聯內容
  created_at TIMESTAMP NOT NULL DEFAULT NOW(), 
  updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
  FOREIGN KEY (ws_id) REFERENCES words (id) ON DELETE CASCADE, 
  FOREIGN KEY (wg_id) REFERENCES words_groups (id) ON DELETE CASCADE 
);