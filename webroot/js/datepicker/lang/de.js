var fdLocale = {
	/* Uncomment the following line if the first day of the week does not start on Monday */
	//firstDayOfWeek:0,
  fullMonths:[
	  "Januar",
	  "Februar",
	  "März",
	  "April",
	  "Mai",
	  "Juni",
	  "Juli",
	  "August",
	  "September",
	  "Oktober",
	  "November",
	  "Dezember"
  ],
 	monthAbbrs:["Jan", "Feb", "Mrz", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"],
  fullDays:[
	  "Montag",
	  "Dienstag",
	  "Mittwoch",
	  "Donnerstag",
	  "Freitag",
	  "Samstag",
	  "Sonntag"
  ],
  dayAbbrs:[
		"Mo",
	  "Di",
	  "Mi",
	  "Do",
	  "Fr",
	  "Sa",
	  "So"
	],

  /* Only stipulate the firstDayOfWeek should the first day not be Monday

  firstDayOfWeek:0,
  */
  titles:[
    "Vorheriger Monat",
    "Nächster Monat",
    "Voriges Jahr",
    "Nächstes Jahr",
    "Heute",
    "Kalender öffnen",
    "KW", 
		"Woche [[%0%]] von [[%1%]]", 
		"Woche", 
		"Datum wählen", 
		"Klicken &amp; Ziehen zum Verschieben", 
		"Zeige [[%0%]] zuerst", 
		"Zu Heute wechseln", 
		"Datum deaktivieren"
  ]
};
try { datePickerController.loadLanguage(); } catch(err) {}
