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
                            "order":"2",
                            "style":"float:right"
                        },
                        {
                            "id":"phone",
                            "question": "Phone N°",
                            "question_fr": "N° de Tél.",
                            "type":"input",
                            "order":"3",
                        },
                        {
                            "id":"adress",
                            "question": "Address",
                            "question_fr": "Adresse",
                            "type":"input",
                            "order":"4",
                            "style":"float:right"
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
                            "order":"6",
                            "style":"float:right"
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
                            "question_fr": "N° de tel",
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
                {
                    "id":"patient",
                    "title": "Patient (if applicable)",
                    "title_fr":"Patient (si applicable)",
                    "questions": [{
                            "id":"birthdate",
                            "question": "date of birth (DD/MM/YYYY)",
                            "question_fr": "Date de naissance (JJ/MM/YYYY)",
                            "type":"input",
                            "order":"1"
                        },
                        {
                            "id":"agedatecollection",
                            "question": "Age at the date of sample collection",
                            "question_fr": "Age à la date du prélèvement",
                            "type":"input",
                            "order":"2",
                            "style":"float:right"
                        },
                        {
                            "id":"gender",
                            "question": "Gender",
                            "question_fr": "Sexe",
                            "type":"radio",
                            "values":"M,F",
                            "order":"3"
                        },
                        {
                            "id":"disease",
                            "question": "disease",
                            "question_fr": "pathologie",
                            "type":"checkbox",
                            "values":"CIM10,OMIM",
                            "order":"4"
                        },
                        {
                            "id":"tnm",
                            "question": "TNM when appropriate",
                            "question_fr": "TNM s'il y'a lieu",
                            "type":"input",
                            "order":"5"
                        },
                        {
                            "id":"undermedication",
                            "question": "Under medication",
                            "question_fr": "Sous traitement",
                            "type":"radio",
                            "values":"yes,no",
                            "order":"6"
                        }, {
                            "id":"ifmedication",
                            "question": "If yes which one?",
                            "question_fr": "Si oui lequel",
                            "type":"input",
                            "order":"7",
                            "style":"float:right",
                        },
                        {
                            "id":"medicalhistory",
                            "question": "Medical history",
                            "question_fr": "Principaux antécédents",
                            "type":"text",
                            "order":"8"
                        },
                        {
                            "id":"agedebut",
                            "question": "Age at the onset",
                            "question_fr": "Age de début",
                            "type":"input",
                            "order":"9"
                        },
                         {
                            "id":"duration",
                            "question": "Duration",
                            "question_fr": "Durée évolutive",
                            "type":"input",
                            "order":"10",
                            "style":"float:right"
                        },
                         {
                            "id":"identifyingpseudo",
                            "question": "Identifying pseudonym",
                            "question_fr": "Identifiant anonymisé",
                            "type":"input",
                        },
                        {
                            "id":"consent",
                            "question": "Signed and informed consent",
                            "question_fr": "Consentement signé",
                            "type":"radio",
                            "values":"yes,no"
                        },
                         {
                            "id":"opposition",
                            "question": "Opposition,non-opposition",
                            "question_fr": "Opposition, non opposition",
                            "type":"input",
                            "style":"float:right"
                        },
                        {
                            "id":"serology",
                            "question": "Serology (VIH, hepatitis)",
                            "question_fr": "Sérologie ( VIH, hépatite)",
                            "type":"input",
                        },
                        ]
                },
                {
                    "id":"sample",
                    "title": "Sample",
                    "title_fr":"Echantillon",
                    "questions": [{
                            "id":"number",
                            "question": "Sample number",
                            "question_fr": "Numéro d'échantillon",
                            "type":"input",
                            "order":"1"
                        },
                        {
                            "id":"species",
                            "question": "Species ( and strain)",
                            "question_fr": "Espèce (et souche)",
                            "type":"input",
                            "order":"2",
                            "style":"float:right"
                        },
                        {
                            "id":"sampletype",
                            "question": "Sample type",
                            "question_fr": "Type d'échantillon",
                            "type":"list",
                            "values":"Tissue/Tissu,Cells/Cellules,RNA/ARN, DNA/ADN, Plasma,Serum, CSF/LCR,PBMC, Buffy Coat, Other/Autre",
                            "order":"3"
                        },
                        {
                            "id":"sampletypeother",
                            "question": "Other Type",
                            "question_fr": "Autre type",
                            "type":"input",
                        },
                        {
                            "id":"source",
                            "question": "Sample source ( organ, tissue)",
                            "question_fr": "Source de l'échantillon (organe, tissu)",
                            "type":"input"
                        },
                        {
                            "id":"pathologicalstatus",
                            "question": "Pathological status of the sample (e.g. affected, non-affected, indication of suspected diagnosis)",
                            "question_fr": "Statut pathologique de l’échantillon (e.g. affecté, non affecté, indication sur le diagnostic suspecté)",
                            "type":"input"
                        }, {
                            "id":"samplecollectiondate",
                            "question": "Sample collection date and time",
                            "question_fr": "Date et heure du prélèvement",
                            "type":"input",
                        },
                        {
                            "id":"samplereceptiondate",
                            "question": "Reception date and time",
                            "question_fr": "Date et heure de réception",
                            "type":"input",
                            "style":"float:right"
                        },
                        {
                            "id":"nbsamples",
                            "question": "Number of deposited sample",
                            "question_fr": "Nombre d’échantillon déposés",
                            "type":"input"
                        },
                         {
                            "id":"Receptionconditions",
                            "question": "Reception conditions(comments)",
                            "question_fr": "Conditions de réception(commentaires)",
                            "type":"text",
                            "style":"float:right"
                        },
                         {
                            "id":"requirements",
                            "question": "Requirements or restriction for distribution",
                            "question_fr": "Conditions requises ou restriction pour la distribution",
                            "type":"radio",
                            "values":"yes/oui,no/non"
                        },
                        {
                            "id":"othersamples",
                            "question": "Other samples for this patient",
                            "question_fr": "Autres échantillons du même patient",
                            "type":"input"
                        },
                         {
                            "id":"documents",
                            "question": "Associated documents",
                            "question_fr": "Documents associés au dépôt",
                            "type":"input",
                        },
                        ]
                }
              ]

})
