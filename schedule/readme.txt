Получение расписания работы сотрудников
/schedule
GET параметры
startDate - дата начала расписания
endDate - дата конца расписания
userId - ID пользователя
get_holidays - 1 - показывать нерабочее расписание, 0 - показывать рабочее. По умолчанию 0.

В случае успеха выдаёт json ответ status OK, shedule при рабочем расписании, status OK, dinner, holidays, vacations, party при нерабочем расписании, где shedule - рабочий график,  dinner - расписание обеда/отдыха, holidays - праздники, vacations - дни отпуска, party - дни корпоратива. 
В случае ошибки - status error и поле error с текстом ошибки.

Пример запроса и ответа:
GET http://localhost/schedule/?startDate=2018-02-20&endDate=2018-02-25&userId=5&get_holidays=0

{
"status":"ok",
"schedule":
	[
		{
			"day":"2018-02-20",
			"timeRanges":[
				{"start":"0600","end":"1300"},
				{"start":"1400","end":"1900"}
			]
		},
		{
			"day":"2018-02-21",
			"timeRanges":[
				{"start":"0600","end":"1300"},
				{"start":"1400","end":"1900"}
			]
		},
		{
			"day":"2018-02-22",
			"timeRanges":[
				{"start":"0600","end":"1300"},
				{"start":"1400","end":"1900"}
			]
		}
	]
}

GET http://localhost/schedule/?startDate=2018-02-20&endDate=2018-02-25&userId=5&get_holidays=1

{
"status":"ok",
"dinner":
	[
		{
			"day":"2018-02-20",
			"timeRanges":
			[
				{"start":"1300","end":"1400"}
			]
		},
		{
			"day":"2018-02-21",
			"timeRanges":
			[
				{"start":"1300","end":"1400"}
			]
		},
		{
			"day":"2018-02-22",
			"timeRanges":
			[
				{"start":"1300","end":"1400"}
			]
		},
		{
			"day":"2018-02-25",
			"timeRanges":
			[
				{"start":"0000","end":"2400"}
			]
		}
	],
"holidays":
	[
		"2018-02-23",
		"2018-02-24"
	],
"vacations":[],
"party":[]
}

Проект развёрнут на localhost посредством xampp, в папке htdocs. JSON данные расписания хранятся в скрытом файле .ht.schedule.