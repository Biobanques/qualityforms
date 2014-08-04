//questionnaire deposit form
db.questionnaire.insert({
    "id":"depositform",
    "questionnaire": "deposit form",
    "description": "deposit form",
    "message_start": "Welcome to the deposit form for DNA/RNA, cells, fluids and tissues (*)1 form per patient and per sampling date (*) 1 fiche par patient et par date de prélèvement",
    "message_end": "Thanks for your job",
    "questions_group":
            [{
                    "id":"depositoridentification",
                    "title": "Depositor identification",
                    "title_fr":"Identification du déposant",
                    "questions": [{
                            "id":"depositorname",
                            "question": "Depositor name",
                            "question_fr": "Nom du déposant",
                            "type":"input",
                            "order":"1"
                        },
                        {
                            "id":"title",
                            "question": "Title",
                            "question_fr": "Titre",
                            "type":"input",
                            "order":"2"
                        },
                        {
                            "id":"phone",
                            "question": "Phone N°",
                            "question_fr": "N° de Tél.",
                            "type":"input",
                            "order":"3"
                        },
                        {
                            "id":"adress",
                            "question": "Address",
                            "question_fr": "Adresse",
                            "type":"input",
                            "order":"4"
                        },
                        {
                            "id":"email",
                            "question": "E-mail",
                            "question_fr": "Courriel",
                            "type":"input",
                            "order":"5"
                        },
                        {
                            "id":"responsible",
                            "question": "Name of the administrator",
                            "question_fr": "Nom du responsable administratif",
                            "type":"input",
                            "order":"6"
                        },
                        ]
                },{
                    "id":"biobankreceivingidentification",
                    "title": "Identification of receiving biobank",
                    "title_fr":"Identification de la biobanque recevant les échantillons",
                    "questions": [{
                            "id":"biobankname",
                            "question": "Biobank name",
                            "question_fr": "Nom de la biobanque",
                            "type":"input",
                            "order":"1"
                        },
                        {
                            "id":"phone",
                            "question": "Phone N°",
                            "question_fr": "N° d etel",
                            "type":"input",
                            "order":"2"
                        },
                        {
                            "id":"adress",
                            "question": "Address",
                            "question_fr": "Adresse",
                            "type":"input",
                            "order":"3"
                        },
                        {
                            "id":"email",
                            "question": "E-mail",
                            "question_fr": "Courriel",
                            "type":"input",
                            "order":"4"
                        },
                        {
                            "id":"responsiblecollection",
                            "question": "Name of the person in charge of collections",
                            "question_fr": "Nom de la personne chargée des collections",
                            "type":"input",
                            "order":"5"
                        },
                        {
                            "id":"responsiblereception",
                            "question": "Name of the person in charge of reception",
                            "question_fr": "Nom de la personne responsable de la réception",
                            "type":"input",
                            "order":"6"
                        }, {
                            "id":"receiverphone",
                            "question": "Phone N°",
                            "question_fr": "N° d etel",
                            "type":"input",
                            "order":"7"
                        },
                        {
                            "id":"receiveradress",
                            "question": "Address",
                            "question_fr": "Adresse",
                            "type":"input",
                            "order":"8"
                        },
                        {
                            "id":"receiveremail",
                            "question": "E-mail",
                            "question_fr": "Courriel",
                            "type":"input",
                            "order":"9"
                        },
                        ]
                },
              ]

})
