//questionnaire deposit form
db.questionnaire.insert({
    "id":"depositform",
    "name": "deposit form",
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
                            "label": "Depositor name",
                            "label_fr": "Nom du déposant",
                            "type":"input",
                            "order":"1"
                        },
                        {
                            "id":"title",
                            "label": "Title",
                            "label_fr": "Titre",
                            "type":"input",
                            "order":"2",
                            "style":"float:right"
                        },
                        {
                            "id":"phone",
                            "label": "Phone N°",
                            "label_fr": "N° de Tél.",
                            "type":"input",
                            "order":"3",
                        },
                        {
                            "id":"adress",
                            "label": "Address",
                            "label_fr": "Adresse",
                            "type":"input",
                            "order":"4",
                            "style":"float:right"
                        },
                        {
                            "id":"email",
                            "label": "E-mail",
                            "label_fr": "Courriel",
                            "type":"input",
                            "order":"5"
                        },
                        {
                            "id":"responsible",
                            "label": "Name of the administrator",
                            "label_fr": "Nom du responsable administratif",
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
                            "label": "Biobank name",
                            "label_fr": "Nom de la biobanque",
                            "type":"input",
                            "order":"1"
                        },
                        {
                            "id":"phone",
                            "label": "Phone N°",
                            "label_fr": "N° de tel",
                            "type":"input",
                            "order":"2"
                        },
                        {
                            "id":"adress",
                            "label": "Address",
                            "label_fr": "Adresse",
                            "type":"input",
                            "order":"3"
                        },
                        {
                            "id":"email",
                            "label": "E-mail",
                            "label_fr": "Courriel",
                            "type":"input",
                            "order":"4"
                        },
                        {
                            "id":"responsiblecollection",
                            "label": "Name of the person in charge of collections",
                            "label_fr": "Nom de la personne chargée des collections",
                            "type":"input",
                            "order":"5"
                        },
                        {
                            "id":"responsiblereception",
                            "label": "Name of the person in charge of reception",
                            "label_fr": "Nom de la personne responsable de la réception",
                            "type":"input",
                            "order":"6"
                        }, {
                            "id":"receiverphone",
                            "label": "Phone N°",
                            "label_fr": "N° d etel",
                            "type":"input",
                            "order":"7"
                        },
                        {
                            "id":"receiveradress",
                            "label": "Address",
                            "label_fr": "Adresse",
                            "type":"input",
                            "order":"8"
                        },
                        {
                            "id":"receiveremail",
                            "label": "E-mail",
                            "label_fr": "Courriel",
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
                            "label": "date of birth (DD/MM/YYYY)",
                            "label_fr": "Date de naissance (JJ/MM/YYYY)",
                            "type":"input",
                            "order":"1"
                        },
                        {
                            "id":"agedatecollection",
                            "label": "Age at the date of sample collection",
                            "label_fr": "Age à la date du prélèvement",
                            "type":"input",
                            "order":"2",
                            "style":"float:right"
                        },
                        {
                            "id":"gender",
                            "label": "Gender",
                            "label_fr": "Sexe",
                            "type":"radio",
                            "values":"M,F",
                            "order":"3"
                        },
                        {
                            "id":"disease",
                            "label": "disease",
                            "label_fr": "pathologie",
                            "type":"checkbox",
                            "values":"CIM10,OMIM",
                            "order":"4"
                        },
                        {
                            "id":"tnm",
                            "label": "TNM when appropriate",
                            "label_fr": "TNM s'il y'a lieu",
                            "type":"input",
                            "order":"5"
                        },
                        {
                            "id":"undermedication",
                            "label": "Under medication",
                            "label_fr": "Sous traitement",
                            "type":"radio",
                            "values":"yes,no",
                            "order":"6"
                        }, {
                            "id":"ifmedication",
                            "label": "If yes which one?",
                            "label_fr": "Si oui lequel",
                            "type":"input",
                            "order":"7",
                            "style":"float:right",
                        },
                        {
                            "id":"medicalhistory",
                            "label": "Medical history",
                            "label_fr": "Principaux antécédents",
                            "type":"text",
                            "order":"8"
                        },
                        {
                            "id":"agedebut",
                            "label": "Age at the onset",
                            "label_fr": "Age de début",
                            "type":"input",
                            "order":"9"
                        },
                         {
                            "id":"duration",
                            "label": "Duration",
                            "label_fr": "Durée évolutive",
                            "type":"input",
                            "order":"10",
                            "style":"float:right"
                        },
                         {
                            "id":"identifyingpseudo",
                            "label": "Identifying pseudonym",
                            "label_fr": "Identifiant anonymisé",
                            "type":"input",
                        },
                        {
                            "id":"consent",
                            "label": "Signed and informed consent",
                            "label_fr": "Consentement signé",
                            "type":"radio",
                            "values":"yes,no"
                        },
                         {
                            "id":"opposition",
                            "label": "Opposition,non-opposition",
                            "label_fr": "Opposition, non opposition",
                            "type":"input",
                            "style":"float:right"
                        },
                        {
                            "id":"serology",
                            "label": "Serology (VIH, hepatitis)",
                            "label_fr": "Sérologie ( VIH, hépatite)",
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
                            "label": "Sample number",
                            "label_fr": "Numéro d'échantillon",
                            "type":"input",
                            "order":"1"
                        },
                        {
                            "id":"species",
                            "label": "Species ( and strain)",
                            "label_fr": "Espèce (et souche)",
                            "type":"input",
                            "order":"2",
                            "style":"float:right"
                        },
                        {
                            "id":"sampletype",
                            "label": "Sample type",
                            "label_fr": "Type d'échantillon",
                            "type":"list",
                            "values":"Tissue/Tissu,Cells/Cellules,RNA/ARN, DNA/ADN, Plasma,Serum, CSF/LCR,PBMC, Buffy Coat, Other/Autre",
                            "order":"3"
                        },
                        {
                            "id":"sampletypeother",
                            "label": "Other Type",
                            "label_fr": "Autre type",
                            "type":"input",
                        },
                        {
                            "id":"source",
                            "label": "Sample source ( organ, tissue)",
                            "label_fr": "Source de l'échantillon (organe, tissu)",
                            "type":"input"
                        },
                        {
                            "id":"pathologicalstatus",
                            "label": "Pathological status of the sample (e.g. affected, non-affected, indication of suspected diagnosis)",
                            "label_fr": "Statut pathologique de l’échantillon (e.g. affecté, non affecté, indication sur le diagnostic suspecté)",
                            "type":"input"
                        }, {
                            "id":"samplecollectiondate",
                            "label": "Sample collection date and time",
                            "label_fr": "Date et heure du prélèvement",
                            "type":"input",
                        },
                        {
                            "id":"samplereceptiondate",
                            "label": "Reception date and time",
                            "label_fr": "Date et heure de réception",
                            "type":"input",
                            "style":"float:right"
                        },
                        {
                            "id":"nbsamples",
                            "label": "Number of deposited sample",
                            "label_fr": "Nombre d’échantillon déposés",
                            "type":"input"
                        },
                         {
                            "id":"Receptionconditions",
                            "label": "Reception conditions(comments)",
                            "label_fr": "Conditions de réception(commentaires)",
                            "type":"text",
                            "style":"float:right"
                        },
                         {
                            "id":"requirements",
                            "label": "Requirements or restriction for distribution",
                            "label_fr": "Conditions requises ou restriction pour la distribution",
                            "type":"radio",
                            "values":"yes/oui,no/non"
                        },
                        {
                            "id":"othersamples",
                            "label": "Other samples for this patient",
                            "label_fr": "Autres échantillons du même patient",
                            "type":"input"
                        },
                         {
                            "id":"documents",
                            "label": "Associated documents",
                            "label_fr": "Documents associés au dépôt",
                            "type":"input",
                        },
                        ]
                }
              ]

})
