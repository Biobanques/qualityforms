//questionnaire deposit form
db.questionnaire.insert({
    "id": "depositform",
    "name": "deposit form",
    "description": "deposit form",
    "message_start": "Welcome to the deposit form for DNA/RNA, cells, fluids and tissues (*)1 form per patient and per sampling date (*) 1 fiche par patient et par date de prélèvement",
    "message_end": "Thanks for your job",
    "questions_group":
            [{
                    "id": "depositoridentification",
                    "title": "Depositor identification",
                    "title_fr": "Identification du déposant",
                    "questions": [{
                            "id": "depositorname",
                            "label": "Depositor name",
                            "label_fr": "Nom du déposant",
                            "type": "input",
                            "order": "1"
                        },
                        {
                            "id": "title",
                            "label": "Title",
                            "label_fr": "Titre",
                            "type": "input",
                            "order": "2",
                            "style": "float:right"
                        },
                        {
                            "id": "phone",
                            "label": "Phone N°",
                            "label_fr": "N° de Tél.",
                            "type": "input",
                            "order": "3",
                        },
                        {
                            "id": "adress",
                            "label": "Address",
                            "label_fr": "Adresse",
                            "type": "input",
                            "order": "4",
                            "style": "float:right"
                        },
                        {
                            "id": "email",
                            "label": "E-mail",
                            "label_fr": "Courriel",
                            "type": "input",
                            "order": "5"
                        },
                        {
                            "id": "responsible",
                            "label": "Name of the administrator",
                            "label_fr": "Nom du responsable administratif",
                            "type": "input",
                            "order": "6",
                            "style": "float:right"
                        },
                    ]
                }, {
                    "id": "biobankreceivingidentification",
                    "title": "Identification of receiving biobank",
                    "title_fr": "Identification de la biobanque recevant les échantillons",
                    "questions": [{
                            "id": "biobankname",
                            "label": "Biobank name",
                            "label_fr": "Nom de la biobanque",
                            "type": "input",
                            "order": "1"
                        },
                        {
                            "id": "phone",
                            "label": "Phone N°",
                            "label_fr": "N° de tel",
                            "type": "input",
                            "order": "2",
                            "style": "float:right"
                        },
                        {
                            "id": "adress",
                            "label": "Address",
                            "label_fr": "Adresse",
                            "type": "input",
                            "order": "3",
                        },
                        {
                            "id": "email",
                            "label": "E-mail",
                            "label_fr": "Courriel",
                            "type": "input",
                            "order": "4",
                            "style": "float:right"
                        },
                        {
                            "id": "responsiblecollection",
                            "label": "Name of the person in charge of collections",
                            "label_fr": "Nom de la personne chargée des collections",
                            "type": "input",
                            "order": "5",
                        },
                        {
                            "id": "responsiblereception",
                            "label": "Name of the person in charge of reception",
                            "label_fr": "Nom de la personne responsable de la réception",
                            "type": "input",
                            "order": "6",
                            "style": "float:right"
                        }, {
                            "id": "receiverphone",
                            "label": "Phone N°",
                            "label_fr": "N° d etel",
                            "type": "input",
                            "order": "7"
                        },
                        {
                            "id": "receiveradress",
                            "label": "Address",
                            "label_fr": "Adresse",
                            "type": "input",
                            "order": "8",
                            "style": "float:right"
                        },
                        {
                            "id": "receiveremail",
                            "label": "E-mail",
                            "label_fr": "Courriel",
                            "type": "input",
                            "order": "9"
                        },
                    ]
                },
                {
                    "id": "patient",
                    "title": "Patient (if applicable)",
                    "title_fr": "Patient (si applicable)",
                    "questions": [{
                            "id": "birthdate",
                            "label": "date of birth (DD/MM/YYYY)",
                            "label_fr": "Date de naissance (JJ/MM/YYYY)",
                            "type": "input",
                            "order": "1"
                        },
                        {
                            "id": "agedatecollection",
                            "label": "Age at the date of sample collection",
                            "label_fr": "Age à la date du prélèvement",
                            "type": "input",
                            "order": "2",
                            "style": "float:right"
                        },
                        {
                            "id": "gender",
                            "label": "Gender",
                            "label_fr": "Sexe",
                            "type": "radio",
                            "values": "M,F",
                            "order": "3"
                        },
                        {
                            "id": "disease",
                            "label": "disease",
                            "label_fr": "pathologie",
                            "type": "checkbox",
                            "values": "CIM10,OMIM",
                            "order": "4",
                        },
                        {
                            "id": "tnm",
                            "label": "TNM when appropriate",
                            "label_fr": "TNM s'il y'a lieu",
                            "type": "input",
                            "order": "5",
                            "style": "float:right"
                        },
                        {
                            "id": "undermedication",
                            "label": "Under medication",
                            "label_fr": "Sous traitement",
                            "type": "radio",
                            "values": "yes,no",
                            "order": "6"
                        }, {
                            "id": "ifmedication",
                            "label": "If yes which one?",
                            "label_fr": "Si oui lequel",
                            "type": "input",
                            "order": "7",
                            "style": "float:right",
                        },
                        {
                            "id": "medicalhistory",
                            "label": "Medical history",
                            "label_fr": "Principaux antécédents",
                            "type": "text",
                            "order": "8"
                        },
                        {
                            "id": "agedebut",
                            "label": "Age at the onset",
                            "label_fr": "Age de début",
                            "type": "input",
                            "order": "9"
                        },
                        {
                            "id": "duration",
                            "label": "Duration",
                            "label_fr": "Durée évolutive",
                            "type": "input",
                            "order": "10",
                            "style": "float:right"
                        },
                        {
                            "id": "identifyingpseudo",
                            "label": "Identifying pseudonym",
                            "label_fr": "Identifiant anonymisé",
                            "type": "input",
                        },
                        {
                            "id": "consent",
                            "label": "Signed and informed consent",
                            "label_fr": "Consentement signé",
                            "type": "radio",
                            "values": "yes,no",
                            "style": "float:right"
                        },
                        {
                            "id": "opposition",
                            "label": "Opposition,non-opposition",
                            "label_fr": "Opposition, non opposition",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "serology",
                            "label": "Serology (VIH, hepatitis)",
                            "label_fr": "Sérologie ( VIH, hépatite)",
                            "type": "input",
                        },
                    ]
                },
                {
                    "id": "sample",
                    "title": "Sample",
                    "title_fr": "Echantillon",
                    "questions": [{
                            "id": "number",
                            "label": "Sample number",
                            "label_fr": "Numéro d'échantillon",
                            "type": "input",
                            "order": "1"
                        },
                        {
                            "id": "species",
                            "label": "Species ( and strain)",
                            "label_fr": "Espèce (et souche)",
                            "type": "input",
                            "order": "2",
                            "style": "float:right"
                        },
                        {
                            "id": "sampletype",
                            "label": "Sample type",
                            "label_fr": "Type d'échantillon",
                            "type": "list",
                            "values": "Tissue/Tissu,Cells/Cellules,RNA/ARN, DNA/ADN, Plasma,Serum, CSF/LCR,PBMC, Buffy Coat, Other/Autre",
                            "order": "3"
                        },
                        {
                            "id": "sampletypeother",
                            "label": "Other Type",
                            "label_fr": "Autre type",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "source",
                            "label": "Sample source ( organ, tissue)",
                            "label_fr": "Source de l'échantillon (organe, tissu)",
                            "type": "input"
                        },
                        {
                            "id": "pathologicalstatus",
                            "label": "Pathological status of the sample (e.g. affected, non-affected, indication of suspected diagnosis)",
                            "label_fr": "Statut pathologique de l’échantillon (e.g. affecté, non affecté, indication sur le diagnostic suspecté)",
                            "type": "input",
                            "style": "float:right"
                        }, {
                            "id": "samplecollectiondate",
                            "label": "Sample collection date and time",
                            "label_fr": "Date et heure du prélèvement",
                            "type": "input",
                        },
                        {
                            "id": "samplereceptiondate",
                            "label": "Reception date and time",
                            "label_fr": "Date et heure de réception",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "nbsamples",
                            "label": "Number of deposited sample",
                            "label_fr": "Nombre d’échantillon déposés",
                            "type": "input"
                        },
                        {
                            "id": "Receptionconditions",
                            "label": "Reception conditions(comments)",
                            "label_fr": "Conditions de réception(commentaires)",
                            "type": "text",
                            "style": "float:right"
                        },
                        {
                            "id": "requirements",
                            "label": "Requirements or restriction for distribution",
                            "label_fr": "Conditions requises ou restriction pour la distribution",
                            "type": "radio",
                            "values": "yes/oui,no/non"
                        },
                        {
                            "id": "othersamples",
                            "label": "Other samples for this patient",
                            "label_fr": "Autres échantillons du même patient",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "documents",
                            "label": "Associated documents",
                            "label_fr": "Documents associés au dépôt",
                            "type": "input",
                        },
                    ]
                },
                {
                    "id": "dnarna",
                    "title": "DNA-RNA",
                    "title_fr": "ADN-ARN",
                    "questions": [{
                            "id": "extractiondate",
                            "label": "Extraction date",
                            "label_fr": "Date d'extraction",
                            "type": "input",
                        },
                        {
                            "id": "extractionmethod",
                            "label": "Extraction method",
                            "label_fr": "Methode d'extraction",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "samplestate",
                            "label": "Sample state",
                            "label_fr": "État de l’échantillon",
                            "type": "radio",
                            "values": "dry/sec,liquid/liquide"
                        },
                        {
                            "id": "samplestatebuffer",
                            "label": "If liquid state the buffer",
                            "label_fr": "Si liquide préciser le tampon",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "weight",
                            "label": "Quantity (as appropriate) Weight (μg)",
                            "label_fr": "Quantité (selon le cas) Poids (μg)",
                            "type": "input",
                        },
                        {
                            "id": "concentration",
                            "label": "Concentration (μg/μl)",
                            "label_fr": "Concentration (μg/μl)",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "volume",
                            "label": "Volume (μl)",
                            "label_fr": "Volume (μl)",
                            "type": "input",
                            "style": "float:right"
                        },
                    ]},
                {
                    "id": "celllines",
                    "title": "Cell lines, primary cells and hybridomas cultures",
                    "title_fr": "Cultures de lignées cellulaires, cellules primaires et hybridomes",
                    "questions": [{
                            "id": "celllinename",
                            "label": "Cell line name",
                            "label_fr": "Nom de la lignée cellulaire",
                            "type": "input",
                        },
                        {
                            "id": "Other cell line names",
                            "label": "Other cell line names",
                            "label_fr": "Autres noms de la lignée",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Celltype",
                            "label": "Cell type",
                            "label_fr": "Type de cellules",
                            "type": "list",
                            "values": "Cell line/lignée,Primary cells/Cellules primaires,Hyridoma/Hybridoma"
                        },
                        {
                            "id": "Cellnature",
                            "label": "Nature of the cells",
                            "label_fr": "Nature des cellules ( e.g épithéliales,fibroblastes...)",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "growthmode",
                            "label": "Growth mode",
                            "label_fr": "Mode de culture",
                            "type": "list",
                            "values": "adherant,semi-adherent,suspension"
                        },
                        {
                            "id": "morphology",
                            "label": "Morphology(picture)",
                            "label_fr": "Morphologie(image)",
                            "type": "input",
                        },
                        {
                            "id": "immortalizationsystem",
                            "label": "Immortalization system",
                            "label_fr": "Système d'immortalisation",
                            "type": "input",
                        },
                        {
                            "id": "isclone",
                            "label": "Is the cell line a clone?",
                            "label_fr": "La lignée est-elle clonale?",
                            "type": "check",
                            "values": "Yes/Oui,No/Non"
                        },
                        {
                            "id": "maincellline",
                            "label": "Main cell line properties",
                            "label_fr": "Principales propriétés de la lignée",
                            "type": "input",
                        },
                        {
                            "id": "Culture medium and conditions",
                            "label": "Culture medium and conditions",
                            "label_fr": "Milieu et conditions de culture",
                            "type": "input",
                        },
                        {
                            "id": "Passage number",
                            "label": "Passage number",
                            "label_fr": "Nombre de passages",
                            "type": "input",
                        },
                        {
                            "id": "Cell number per tube",
                            "label": "Cell number per tube",
                            "label_fr": "Nombre de cellules par tube",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Date of freezing (DD/MM/YYYY)",
                            "label": "Date of freezing (DD/MM/YYYY)",
                            "label_fr": "Date de congélation (JJ/MM/AAAA)",
                            "type": "input",
                        },
                        {
                            "id": "Freezing medium",
                            "label": "Freezing medium",
                            "label_fr": "Milieu de congélation",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Is the depositor the originator?",
                            "label": "Is the depositor the originator?",
                            "label_fr": "Le déposant est-il l’auteur ?",
                            "type": "radio",
                            "values": "Yes/Oui,No/Non"
                        },
                        {
                            "id": "If no, specify",
                            "label": "If no, specify",
                            "label_fr": "Si non, préciser",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "GMO agreement number",
                            "label": "GMO agreement number",
                            "label_fr": "Numéro d’agrément OGM",
                            "type": "input",
                        },
                        {
                            "id": "Parental cell line name",
                            "label": "Parental cell line name",
                            "label_fr": "Nom de la lignée parentale",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Expressed protein",
                            "label": "Expressed protein",
                            "label_fr": "Protéine exprimée",
                            "type": "input",
                        },
                        {
                            "id": "Gene of interest",
                            "label": "Gene of interest",
                            "label_fr": "Gène d'intérêt",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Gene source species",
                            "label": "Gene source species",
                            "label_fr": "Espèce dont est issu le gène",
                            "type": "input",
                        },
                        {
                            "id": "Sequence accession number",
                            "label": "Sequence accession number",
                            "label_fr": "Numéro d’accession de la séquence",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Vector name",
                            "label": "Vector name",
                            "label_fr": "Nom du vecteur",
                            "type": "list",
                            "values": "retrovirus,adenovirus,plasmid/plasmide, other/autre"
                        },
                        {
                            "id": "Gene expression system",
                            "label": "Gene expression system",
                            "label_fr": "Système d'expression du gène",
                            "type": "list",
                            "values": "promoter/prompoteur,regulation/régulation,tag/etiquette,other/autre",
                            "style": "float:right"
                        },
                        {
                            "id": "Other vector",
                            "label": "Other vector",
                            "label_fr": "Autre vecteur",
                            "type": "input",
                        },
                        {
                            "id": "Other expression system",
                            "label": "Other expression system",
                            "label_fr": "Autre système d'expression",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Selection antibiotic",
                            "label": "Selection antibiotic",
                            "label_fr": "Agent de sélection",
                            "type": "input",
                        },
                        {
                            "id": "Hybridoma source species",
                            "label": "Hybridoma source species",
                            "label_fr": "Espèces dont est issu l’hybridome",
                            "type": "input",
                        },
                        {
                            "id": "Parental plasmocytoma",
                            "label": "Parental plasmocytoma",
                            "label_fr": "Plasmocytome parental",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Produced antibody",
                            "label": "Produced antibody",
                            "label_fr": "Anticorps produit",
                            "type": "input",
                        },
                        {
                            "id": "Immunogen",
                            "label": "Immunogen",
                            "label_fr": "Immunogène",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Antibody isotype",
                            "label": "Antibody isotype",
                            "label_fr": "Isotype de l’anticorps",
                            "type": "input",
                        },
                        {
                            "id": "Antibody production yield",
                            "label": "Antibody production yield",
                            "label_fr": "Rendement de la production d’anticorps",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Antibody specificity",
                            "label": "Antibody specificity",
                            "label_fr": "Spécificité de l’anticorps",
                            "type": "input",
                        },
                    ]
                },
                {
                    "id": "fluids",
                    "title": "Fluids",
                    "title_fr": "Fluides",
                    "questions": [{
                            "id": "Sample weight (g)",
                            "label": "Sample weight (g)",
                            "label_fr": "Poids de l'échantillon (g)",
                            "type": "input",
                        },
                        {
                            "id": "Sample volume (ml)",
                            "label": "Sample volume (ml)",
                            "label_fr": "Volume de l'échantillon (ml)",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Possible limits for sample utilisation",
                            "label": "Possible limits for sample utilisation(In the case of non-conformance)",
                            "label_fr": "Limites éventuelles d'utilisation des échantillons(En cas de non-conformité)",
                            "type": "text"
                        },
                        {
                            "id": "Anticoagulant",
                            "label": "Anticoagulant",
                            "label_fr": "Anticoagulant",
                            "type": "list",
                            "values": "EDTA,Heparin/Héparine,Citrate,Other/Autre"
                        },
                        {
                            "id": "Other anticoagulant",
                            "label": "Other anticoagulant",
                            "label_fr": "Autre anticoagulant",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Aprotinin or other antiprotease",
                            "label": "Aprotinin or other antiprotease",
                            "label_fr": "Aprotinine ou autre antiprotéase",
                            "type": "radio",
                            "values": "Yes/Oui,No/Non"
                        },
                        {
                            "id": "If yes specify",
                            "label": "If yes specify",
                            "label_fr": "Si oui préciser",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Sample preparation protocol",
                            "label": "Sample preparation protocol",
                            "label_fr": "Protocole de préparation de l’échantillon",
                            "type": "text",
                            "style": "float:right"
                        },
                    ]
                },
                {
                    "id": "tissues",
                    "title": "Tissues",
                    "title_fr": "Tissus",
                    "questions": [{
                            "id": "Sample preparation site",
                            "label": "Sample preparation site",
                            "label_fr": "Lieu de préparation de l’échantillon",
                            "type": "input",
                        },
                        {
                            "id": "Sample preparation date",
                            "label": "Sample preparation date(dd/mm/yyyy)",
                            "label_fr": "Date de préparation(jj/mm/aaaa)",
                            "type": "input",
                        },
                        {
                            "id": "Person performing the secondary sampling",
                            "label": "Person performing the secondary sampling",
                            "label_fr": "Personne réalisant l’échantillonnage secondaire",
                            "type": "input"
                        },
                        {
                            "id": "Test prion",
                            "label": "Test prion",
                            "label_fr": "Test prion",
                            "type": "text",
                        },
                        {
                            "id": "Associated diagnosis",
                            "label": "Associated diagnosis",
                            "label_fr": "Diagnostics associés",
                            "type": "array",
                            "columns": "Affected/pathologique,Non affected/Non pathologique",
                            "rows": "site 1, site 2, site 3"
                        },
                        {
                            "id": "Tumor grade",
                            "label": "Tumor grade",
                            "label_fr": "Grade de la tumeur",
                            "type": "radio",
                            "values": "Yes/Oui,No/Non"
                        },
                        {
                            "id": "Tumor type / Type de la tumeur",
                            "label": "Tumor type / Type de la tumeur",
                            "label_fr": "Tumor type / Type de la tumeur",
                            "type": "list",
                            "values": "Metastasis/Métastases,Primory tumor/Tumeur primaire,Tumor reccurence, Récidive de la tumeur,Other/Autre",
                            "style": "float:right"
                        },
                        {
                            "id": "Molecular biology exams",
                            "label": "Molecular biology exams",
                            "label_fr": "Examens de biologie moléculaire",
                            "type": "radio",
                            "values": "Yes/Oui,No/Non"
                        },
                        {
                            "id": "If yes, results",
                            "label": "If yes, results",
                            "label_fr": "Si oui, résultats",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Documentation on processing method (e.g. formaldehyde fixation...)",
                            "label": "Documentation on processing method (e.g. formaldehyde fixation...)",
                            "label_fr": "Documentation sur la méthode de préparation (e.g. fixation au formaldéhyde...)",
                            "type": "input",
                        },
                    ]
                },
                {
                    "id": "Storage, packaging and transport",
                    "title": "Storage, packaging and transport",
                    "title_fr": "Conservation, conditionnement et transport",
                    "questions": [{
                            "id": "Temperature",
                            "label": "Temperature",
                            "label_fr": "Temperature",
                            "type": "input",
                        },
                        {
                            "id": "Conditions (liquid N2, freezer, filter...)",
                            "label": "Conditions (liquid N2, freezer, filter...)",
                            "label_fr": "Conditions (azote liquide, congélateur, filtre...)",
                            "type": "input",
                            "style": "float:right"
                        },
                        {
                            "id": "Storage temperature monitoring",
                            "label": "Storage temperature monitoring",
                            "label_fr": "Suivi de la température de conservation",
                            "type": "radio",
                            "values": "Yes/Oui,No/Non"
                        },
                        {
                            "id": "Packaging of received sample (dry ice, room temperature...)",
                            "label": "Packaging of received sample (dry ice, room temperature...)",
                            "label_fr": "Conditionnement de l’échantillon reçu (carboglace, température ambiante...)",
                            "type": "text",
                        },
                    ]
                },
                  {
                    "id": "Reception conditions: non-conformance",
                    "title": "Reception conditions: non-conformance",
                    "title_fr": "Conditions de réception : non- conformité",
                    "questions": [{
                            "id": "Reception conditions (temperature/delay)",
                            "label": "Reception conditions (temperature/delay)",
                            "label_fr": "Conditions de réception (température, délai)",
                            "type": "check",
                            "values":"Conditions of transport were not filled (temperature) / Conditions de transport non respéctées (température),Delay between the sampling and the arrival at the biobank /Délai entre le prélèvement et l'arrivée au laboratoire,Delay between the arrival at the biobank and freezing / Délai entre l'arrivée au laboratoire et la congélation"
                        },
                        {
                            "id": "Sample / Echantillon",
                            "label": "Sample / Echantillon",
                            "label_fr": "Sample / Echantillon",
                            "type": "check",
                            "values":"No sample-empty / Absence d'échantillon-vide,Setteled / Décanté,Broken-damaged during transport / Cassé-accidenté pendant le transport,Broken- damaged during handling / Cassé- endomagé pendant le traitement par le CRB,Incorrect sample number / Nombre incorrect d'échantillons,Wrong tube for the analysis / Tube incorrect pour l'analyse demandée,Insufficient volume / Volume insuffisant,Clotted, hemolysed / Coagulé, hémolysé,Other / Autre"
                        },
                        {
                            "id": "Storage temperature monitoring",
                            "label": "Storage temperature monitoring",
                            "label_fr": "Suivi de la température de conservation",
                            "type": "radio",
                            "values": "Yes/Oui,No/Non"
                        },
                        {
                            "id": "Packaging of received sample (dry ice, room temperature...)",
                            "label": "Packaging of received sample (dry ice, room temperature...)",
                            "label_fr": "Conditionnement de l’échantillon reçu (carboglace, température ambiante...)",
                            "type": "text",
                        },
                    ]
                }

            ]

})
