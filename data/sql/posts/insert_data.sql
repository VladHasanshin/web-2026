USE blog;

INSERT INTO
	user (
		user_name,
		avatar_path
    ) 
VALUES (
	'Ваня Денисов',
	'./img/vanya_denisov.jpg'
),
(
    'Лиза Дёмина',
    './img/liza_demina.jpg'
);

INSERT INTO
	post (
		title,
		image_path,
        post_text,
        likes_count,
        post_time
    ) 
VALUES (
	'Пост - Ваня Денисов',
	'./img/winter_street.jpg,./img/vanya_denisov.jpg,./img/img_1777387934_874.jpg',
	'Так красиво сегодня на улице! Настоящая зима)) Вспоминается 
    Бродский: «Поздно ночью, в уснувшей долине, на самом дне, в городке, 
    занесенном снегом по ручку двери...»',
    '203',
    DATE_SUB(NOW(), INTERVAL 2 HOUR)
),
(
    'Пост - Лиза Дёмина',
    './img/book_and_fish.jpg',
    'Иногда счастье — это всего лишь хорошая книга, уютный вечер
    и такие маленькие гастрономические удовольствия. В этом есть своя поэзия.',
    '523',
    DATE_SUB(NOW(), INTERVAL 5 DAY)
);