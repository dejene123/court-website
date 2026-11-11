CREATE DATABASE IF NOT EXISTS shaggar_court_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shaggar_court_db;

-- 1. News Articles Table
CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publish_date DATE NOT NULL,
    summary TEXT NOT NULL,
    content TEXT,
    image_url VARCHAR(255) DEFAULT 'assets/news_placeholder.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. President Profile Table
CREATE TABLE IF NOT EXISTS president_profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    is_active BOOLEAN DEFAULT TRUE
);

-- 3. Court Services Table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_om VARCHAR(255) NOT NULL,
    title_en VARCHAR(255) NOT NULL,
    description_om TEXT NOT NULL,
    description_en TEXT NOT NULL,
    icon_class VARCHAR(100) DEFAULT 'fas fa-briefcase',
    link_url VARCHAR(255) DEFAULT '#'
);

-- 4. Former Presidents Table
CREATE TABLE IF NOT EXISTS former_presidents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    term_period VARCHAR(100) NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    display_order INT DEFAULT 0
);


CREATE TABLE IF NOT EXISTS news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    publish_date DATE NOT NULL,
    summary TEXT NOT NULL,
    content TEXT NOT NULL,
    category VARCHAR(50) NOT NULL, -- e.g., 'ecourt', 'leenjii', 'murtii', 'beeksisa'
    author VARCHAR(100) DEFAULT 'Waajjira Presidaantii',
    image_url VARCHAR(255) DEFAULT 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=600&q=80',
    views INT DEFAULT 100,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);




-- Seed Services Data
INSERT INTO services (title_om, title_en, description_om, description_en, icon_class) VALUES
('E-Filing', 'E-Filing Portal', 'E-Faayilingiin abbaan dhimma ol\'iyyaata isaa gara Mana Murtii barbaaduutti karaa elektrooniksii (online) dhaan ergu kan isa danddesiisu dha.', 'Submit your case documents and follow the process online using our secure e-filing portal.', 'fas fa-file-alt'),
('Tajaajila Hiikaa Afaanii', 'Language Translation Service', 'Tajaajila hiika afaanii ni kennina..', 'We provide specialized legal translation services.', 'fas fa-globe'),
('Bilbila Tolaa 8794', 'Toll-Free Hotline 8794', 'Tajaajila bilbila tolaa fayyadamuun Abbaan Dhimmaa galmeen isaa maal irra akka jiru kan itti hordoofatu dha..', 'Using a toll-free telephone service, clients can track case status instantly.', 'fas fa-phone-alt'),
('Tajaajila Abukaattoo', 'Legal Aid & Defense', 'Tajaajila gorsa seeraa fi abukaattoo ittisaa.', 'Legal consultation and defense lawyer representation services.', 'fas fa-gavel'),
('Qabeenya & Lafaa', 'Land & Asset Consultancy', 'Gorsa seeraa lafaa fi galmeessa qabeenyaa.', 'Professional guidance on land registration, asset management, and investment portfolios.', 'fas fa-building'),
('Tajaajila Afaan Dabalataa', 'Additional Language Service', 'Tajaajila hiika afaanii fi aadaa dabalataa.', 'Specialized language interpretation offerings for official court cases.', 'fas fa-comments');

-- Seed Former Presidents Data
INSERT INTO former_presidents (name, term_period, image_url, display_order) VALUES
('Obbo Bojaa Taaddasaa Kaasahuun', '01.05.2002 – 30.03.2005', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80', 1),
('Obbo Dhugumaa Nadhaa Araddaa', '01.04.2005 – 30.06.2009', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&q=80', 2),
('Obbo Mul\'isaa Ejjetaa Walannee', '01.07.2009 – 30.12.2010', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&q=80', 3),
('Obbo Oliyyaad Siyyum Ayyaanaa', '01.01.2011 – 12.06.2013', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400&q=80', 4);


-- Gallery Table
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'news', -- 'news', 'presidents', 'events'
    image_url TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Gallery Images (Matching the screenshot grid order)
INSERT INTO gallery (title, category, image_url) VALUES
('Delegation Meeting Session 1', 'news', 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=800&q=80'),
('Delegation Meeting Session 2', 'news', 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=800&q=80'),
('Official Group Photo Session', 'news', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&q=80'),
('Staff Discussion and Evaluation', 'news', 'https://images.unsplash.com/photo-1531497865144-0464ef8fb9a9?w=800&q=80'),
('Judicial Experience Sharing Workshop', 'news', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&q=80'),
('Court Committee Meeting', 'news', 'https://images.unsplash.com/photo-1431540015161-0bf868a2d407?w=800&q=80'),
('Official Speech and Press Release', 'presidents', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=800&q=80'),
('High Court Leadership Assembly', 'news', 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=800&q=80'),
('President Office Presentation', 'presidents', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80'),
('Bar Association Annual Assembly', 'news', 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800&q=80'),
('Legal Professionals Training Seminar', 'news', 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80'),
('Court Staff Honor Ceremony', 'news', 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=800&q=80'),
('Ceremonial Cake Cutting Event', 'events', 'https://images.unsplash.com/photo-1513151233558-d860c5398176?w=800&q=80'),
('E-Court System Training Workshop', 'news', 'https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&q=80'),
('Digital Court Technology Demonstration', 'news', 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=800&q=80'),
('ICT Infrastructure Orientation Session', 'news', 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800&q=80'),
('President Keynote Speech', 'presidents', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=800&q=80');


-- Folders Table
CREATE TABLE IF NOT EXISTS folders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    folder_name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

-- Documents / Publications Table
CREATE TABLE IF NOT EXISTS publications (
    id INT AUTO_INCREMENT PTRIMARY KEY, -- corrected syntax below in code block
    title VARCHAR(255) NOT NULL,
    folder_slug VARCHAR(100) NOT NULL,
    file_size VARCHAR(50) DEFAULT '2.4 MB',
    file_url VARCHAR(255) DEFAULT '#',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Re-run with clean syntax if needed:
DROP TABLE IF EXISTS publications;
DROP TABLE IF EXISTS folders;

CREATE TABLE folders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    folder_name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE publications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    folder_slug VARCHAR(100) NOT NULL,
    file_size VARCHAR(50) DEFAULT '3.1 MB',
    file_url VARCHAR(255) DEFAULT '#',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Seed Folders
INSERT INTO folders (folder_name, slug) VALUES
('All', 'all'),
('Cassations', 'cassations'),
('Heera Mootummaa Itoophiyaa', 'heera-mootummaa'),
('Labsillee', 'labsillee'),
('Murtiilee Barssisoo', 'murtiilee-barssisoo'),
('Qajeeltamoota', 'qajeeltamoota'),
('Seerota', 'seerota');

-- Seed Publications matching the screenshot
INSERT INTO publications (title, folder_slug, file_size) VALUES
('cassation volume 15', 'cassations', '4.2 MB'),
('Heera Mootummaa Federaalaa Afaan Oromoon', 'heera-mootummaa', '3.5 MB'),
('cassation volume 25', 'cassations', '5.1 MB'),
('cassation volume 24', 'cassations', '4.8 MB'),
('cassation volume 23', 'cassations', '3.9 MB'),
('cassation volume 22', 'cassations', '4.0 MB'),
('cassation volume 21', 'cassations', '3.7 MB'),
('cassation volume 20', 'cassations', '4.1 MB'),
('cassation volume 19', 'cassations', '3.8 MB'),
('cassation volume 18', 'cassations', '3.6 MB'),
('cassation volume 17', 'cassations', '4.0 MB'),
('cassation volume 16', 'cassations', '3.9 MB'),
('cassation volume 1-3', 'cassations', '6.5 MB'),
('cassation volume 14', 'cassations', '3.5 MB'),
('cassation volume 13', 'cassations', '3.7 MB'),
('cassation volume 12', 'cassations', '3.8 MB'),
('cassation volume 11', 'cassations', '3.6 MB'),
('cassation volume 10', 'cassations', '3.4 MB'),
('cassation volume 9', 'cassations', '3.5 MB'),
('cassation volume 8', 'cassations', '3.7 MB'),
('cassation volume 7', 'cassations', '3.3 MB'),
('cassation volume 6', 'cassations', '3.5 MB'),
('cassation volume 5', 'cassations', '3.2 MB'),
('cassation volume 4', 'cassations', '3.4 MB');


-- Staff Directory Table
CREATE TABLE IF NOT EXISTS staff_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    role_title VARCHAR(255) NOT NULL,
    image_url TEXT NOT NULL,
    display_order INT DEFAULT 0
);

-- Seed Staff Records matching the layout
INSERT INTO staff_members (full_name, role_title, image_url, display_order) VALUES
('Obbo Kumalaa Buusaa', 'Prezidaantii Mana Murtii Olaanaa Magaalaa Shaggar', 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&q=80', 1),
('Aadde Najaat Mohammed', 'I/A Pirezidaantii', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&q=80', 2),
('Obbo Abdii Dasaalayyoo Namaniisa', 'Deeskootara Hooggansa Qabeenya Namaa', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=80', 3),
('Gammachuu Guddataa Safaroo', 'Ogeessa Oomishaa Seeraa', 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=600&q=80', 4),
('Obbo Tuquruu Tuufayyuu Eessaa', 'I/A Qindaaessaa Waa jiroo Naannoofi Inspecshinii', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=600&q=80', 5),
('Birees Dabaalee Duubea', 'Gaggeessaa Dhimmoota', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=600&q=80', 6),
('Abajee Allotiny Kaasahuun', 'Deesktoorara Haroomaa', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&q=80', 7),
('Obbo Gutaazeeoo Balaaeeoo Kabbee', 'Deesktoorara Hojii Dijitaalizaashiniif Ntsuuma TCO', 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=600&q=80', 8),
('Obbo Magarsaa Dhulasaa Gidasaa', 'Deesktoorara Gatii Keessaa', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=600&q=80', 9),
('Gammachuu Dirribuu', 'I/I Gaaftamasmaa Waajjira Sumii Abbootii Seeraa fi Qabeenya Humna Namaa.', 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=600&q=80', 10),
('Abaasa G/Haseen Gaasummaa', 'Daarktoora Bilisaa Bul. Fayyintumaati Qabanyyaa', 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=600&q=80', 11);


-- Court Overview / About Us Content Table
CREATE TABLE IF NOT EXISTS court_overview (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content_text TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Seed Content Matching the Screenshot
INSERT INTO court_overview (title, content_text) VALUES 
('Court Overview / Seensa Mana Murtichaa', 
'Heera Mootummaa FDRI bara 1987 bahee hojiirra oole keewwata 78(3) jalatti Naannoleen Mana Murtii Waliigalaa, Ol\'aanaa fi Sadarkaa Duraa Naannoo isaanii hundeeffachuu akka qaban tumeera. Heerri Mootummaa Naannoo Oromiyaa bara 1987 bahes Mana Murtii Waliigalaa, Manneen Murtii Ol\'aanaa Godinaalee fi Manneen Murtii Aanaalee heerichaan akka hundaa\'an tumeera.<br><br>'
'Labsiileen hundeeffama Manneen Murtii yeroodhaa gara yerootti haala jijjiirrama yeroo waliin wal simuun fooyy\'aa akka deeman ta\'eera. Haaluma kanaan hojiirra kan ture labsiin lakk. 141/2000 bara 2011 keessa labsii lakk. 216/2011\'n akka bakka bu\'u ta\'eera. Labsiin lakk.216/2011 kun aangoon abbaa seerummaa Manneen Murtii Aanaalee akka ol\'u gochuun uummanni tajaajila abbaa seerummaa bakka jiraatu irraa osoo hin fogaatin akka argatu kan dandeessisee dha. Kanaan gammattis tajaajilli abbaa seerummaa kallattii qulqullina, dhaqqabamummaa, si\'ayinaa fi gama hundaan bu\'a qabeessa akka ta\'u haala dandeessisuun qophaa\'e kan hojiirra oole dha.<br><br>'
'Akkasumas yeroo walfakkaataaf hojiirra kan ture labsiin 142/2011 labsii Gumii Bulchiinsa Abbootii Seeraa Oromiyaa (217/2011) tiin bakka bu\'ee bulchiinsa Manneen Murtii bilisaa fi gaggeessummaa kennamu ilaalchisee bifa haaraan aangoo bulchiinsa Manneen Murtii gara jalaatti kan gadi buusee fi sirna itti gaafatamummaas ta\'e bulchiinsa waligalaa Manneen Murtii ilaallatu keessa deebiin fooyy\'ee akka bahu taasifameera.<br><br>'
'Manneen Murtii Magaalaa Shaggariis Labsii 216/2011 fi dambii Bulchiinsa Magaalaa Shaggar hundeessuuf bahe Lakk. 233/215 Kewwata 10 (2) fi (3) Gurmaa\'iinsa qaamolee mootummaa bulchiinsa Magaalichaatiin Mana Murtii Aangoo Abbaa Seerummaa qabu ta\'e Sadarkaa Magalaatti Mana Murtii Ol\'aanaa tokko Sadarkaa Kutaalee Magalaatti Manneen Murtii Aanaalee 12 fi Mana Murtii Aanaa Magaalaa Finfinnee Aangoo dantaa mootummaa naannoo Oromiyaa Magaalaa Finfinnee qabu ilaaluu hundeessuun tajaajila abbaa seerummaa kennaa jira.'
);


-- Mission, Vision and Values Content Table
CREATE TABLE IF NOT EXISTS court_mission_vision (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section_title VARCHAR(255) NOT NULL,
    content_html TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Seed Content Matching the Screenshot
INSERT INTO court_mission_vision (section_title, content_html) VALUES 
('Vision Mission and Values', 
'<h3 style="color: #0c2340; font-size: 1.1rem; margin-bottom: 8px; font-weight: bold;">I. Ergama</h3>'
'<p style="margin-bottom: 12px;">Ergamni waloo Manneen Murtii Magaalaa Shaggar kun akkuma eegamtti ta’ee:</p>'
'<p style="margin-bottom: 12px;">Manni Murtii Ol’anaa bu’uraan Mana Murtii ol’iyyannoo ta’ee, hir’ina yookiin dogongora seeraa yookiin ijoo dubbii, walumatti hir’ina murtiin Mana Murtii jalaa qabu ol’iyyannoodhaan dhagahee sirreessuu;</p>'
'<p style="margin-bottom: 20px;">Manni Murtii Aanaa Mana Murtii sadarkaa jalqabaa ta’ee, dhimmoota gaaffiin abbaa seerummaa itti gaafatame ofitti fuudhee sadarkaa jalqabaatiin ilaalee murtii kennuu dha.</p>'

'<h3 style="color: #0c2340; font-size: 1.1rem; margin-bottom: 8px; font-weight: bold;">II. Mul’ata</h3>'
'<p style="margin-bottom: 20px;">Bara 2022tti Mana Murtii Seera Hiikuun Haqaa fi Ol’aantummaa Seeraa Mirkaneessee Amantaa Horatee Biyyaa Keenya Keessatti Fakkeenya Ta’e Arguu;</p>'

'<h3 style="color: #0c2340; font-size: 1.1rem; margin-bottom: 8px; font-weight: bold;">III. Duudhaalee</h3>'
'<ul style="list-style-type: disc; padding-left: 20px; line-height: 1.8;">'
'<li>Bilisummaa fi itti gaafatamummaa abbaa seerummaa /judicial independence and accountability/</li>'
'<li>Beekumsaa fi Gahumsa /knowledge and competence/</li>'
'<li>Miira tajaajiltummaa /sense of stewardship/</li>'
'<li>Iftoomina /transparency/</li>'
'<li>Fayyalummaa /Propriety/</li>'
'<li>Al-loogummaa fi wal-qixxummaa /Impartiality and equality/</li>'
'</ul>'
);


-- President Message Table
CREATE TABLE IF NOT EXISTS president_message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    president_name VARCHAR(255) NOT NULL,
    president_title VARCHAR(255) NOT NULL,
    image_url TEXT NOT NULL,
    salutation TEXT NOT NULL,
    message_body TEXT NOT NULL,
    closing_quote VARCHAR(255) NOT NULL,
    signature_date VARCHAR(100) NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Seed Content Matching the Screenshot
INSERT INTO president_message (president_name, president_title, image_url, salutation, message_body, closing_quote, signature_date) VALUES 
(
    'Kumalaa Buusaa Fedhasaa',
    'Pirezidaantii Mana Murtii Olaanaa Magaalaa Shaggar',
    'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=600&q=80',
    'Kabajamtoota Uummata naannoo keenyaa, qaamolee haqaa fi qooda fudhattoota hundaaf,',
    'Manni Murtii Olaanaa Magaalaa Shaggar, angoo seera hiikuu heeraan kennameef bu\'uureffachuun tajaajila abbaa seerummaa seera irratti hundaa\'e kennaa kan ture yoo ta\'u, tajaajila abbaa seerummaa abbaan dhimmaa qaamaan mana murtiitti dhiyaatee tajaajilamaa ture kanas daran dhaqqabamaa fi si\'ataa taasisuuf rifoormiiwwan Mana Murtii Waliigalaa Oromiyaatiin diriire moosaajii Court Automation System (CAS) fayyadamuudhaan galmeen ol iyyannoo mana murtii sadarkaa jalqabaatiin murtii kenne irraa gareen komii qabu karaa sirna electronic filing(e-filing) tiin mana murtii dhimma isaa jalqaba ilaalee murtii kenne irraa komii ol iyyannoo mana murtii ol iyyata dhagahu biratti dhiyeeffatee qaamaan mana murtii osoo hin dhiyaatiin karaa Viidiyoo Konfiraansiitiin tajaajilli kennamaa turee jira.<br><br>'
    'Bara kana immoo manni murtii Olaanaa Magaalaa Shaggar moosaajii Shagar e-court system jedhamu dhaabbata CYBER Software jedhamu waliin ta\'uudhaan moosaajii nageenyummaan isaa dhaabbata Odeeffannoo fi Nageenya Biyyaalessaa Itiyoophiyaa (Information Network Security Agency (INSA)dhaan mirkanaa\'e misoomsuudhaan tajaajila abbaa seerummaa Manneen murtii Magaalaa Shaggar sadarkaa lamaanittuu kennamu guutummaatti Sirna falmii elektiroonikaatti ceesisuun hojii keessa galee jira. Moosaajii shagar E-court jedhamu kun abbaan dhimmaa, Abukaattonni dhuunfaa fi qaamoleen haqaa biroo dhimma isaanii mana murtiitti yoo dhiyeeffatan karaa Poortaalii fayyadamuudhaan Mana isaanii yookiin Waajira dhuunfaa isaanii taa\'anii iyyannoo, himannaa, deebii, waliigalatti tajaajila abbaa seerummaa barbaadan hunda karaa moosaajii shager e-court tiin ergatanii, kaffaltiiwwan tajaajila abbaa seerummaa karaa Tele birr moosaajicha waliin wal qabatee jiruutiin raawwachuudhaan bakkuma jiran taa\'anii tajaajila abbaa seerummaa guutuu argachuu kan isaan dandeessisu yoo ta\'u, moosaajiin kun baasii fi dhamaatii abbaa dhimmaa kan xiqqeessu qofaa osoo hin taane, dhaqqabamummaa fi si\'aayina akkasumas iftoominaa fi itti gaafatamummaa kenninsa tajaajila abbaa seerummaa daran akka dabalu taasisee jira.<br><br>'
    'Manni murtii olaanaa magaalaa shaggar yeroo ammaa kana immoo Marsariitii (website) mataa isaa banatee kan jiru yoo ta\'u, odeeffannoowwanii fi kenna tajaajila abbaa seerummaa manneen murtichaa haala dhaqqabamaa fi si\'ataa ta\'een kennuuf daran hawaasatti dhiyaachuusaa yoon ibsu gammachuu guddaadhaani.<br><br>'
    'Manneen murtii keenya imaanaa uummataa fi heera mootummaatiin tajaajila abbaa seerummaa qulqulluu fi si\'ataa kan seera qofa irratti hundaa\'e kennuuf dirqama isaanitti kenname bahachuuf yoomiyyuu caalaa ciminaan hojjechaa kan jiran yoo ta\'u, weebsaayitiin kun banamuun hawaasni keenya dhimma isaanii haala salphaa fi eessattuu dhaqqabamaa ta\'een hordofachuu fi odeeffannoo wayitaawaa argachuuf kan tajaajilu waan ta\'eef akka dhimma itti bahan jechaa, qaamolee fi qooda fudhattoota hojiin kun akka milkaa\'u taasisan hunda galatoomaa jechuu barnaanna.',
    'Haqaaf, haqaan hojjenna !',
    'Onkololeessa bara 2018'
);


-- Feedback & Ethics Complaints Table
CREATE TABLE IF NOT EXISTS feedback_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    department VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    attachment_path VARCHAR(255) DEFAULT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sub-Courts Table
CREATE TABLE IF NOT EXISTS sub_courts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    court_name VARCHAR(255) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    is_active BOOLEAN DEFAULT FALSE
);

-- Streaming Channels Table
CREATE TABLE IF NOT EXISTS stream_channels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sub_court_id INT NOT NULL,
    channel_name VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL, -- 'general', 'family', 'criminal'
    stream_url TEXT NOT NULL,
    FOREIGN KEY (sub_court_id) REFERENCES sub_courts(id) ON DELETE CASCADE
);

-- Seed Sub-Courts
INSERT INTO sub_courts (court_name, slug, is_active) VALUES
('Furii', 'furii', FALSE),
('Sabbataa', 'sabbataa', FALSE),
('Koyyee Faccee', 'koyyee-faccee', FALSE),
('Sulultaa', 'sulultaa', FALSE),
('Kuraa Jiddaa', 'kuraa-jiddaa', FALSE),
('Mana Abbichuu', 'mana-abbichuu', FALSE),
('Buraayyuu', 'buraayyuu', FALSE),
('Malkaa Noonnoo', 'malkaa-noonnoo', FALSE),
('Gafarsa Gujee', 'gafarsa-gujee', FALSE),
('MMO Magaalaa Shaggar', 'mmo-magaalaa-shaggar', FALSE),
('Laga Xaafoo Laga Daadhii', 'laga-xaafoo', FALSE),
('Galaan', 'galaan', TRUE),
('Galaan Guddaa', 'galaan-guddaa', FALSE),
('Finfinnee', 'finfinnee', FALSE),
('E-Court', 'e-court', FALSE);

-- Seed Streaming Channels for Galaan Court
INSERT INTO stream_channels (sub_court_id, channel_name, category, stream_url) VALUES
(12, 'Dhaddachaa HH 1ffaa', 'general', '#'),
(12, 'Dhaddachaa HH.2ffaa', 'general', '#'),
(12, 'Dhaddachaa HH.3ffaa', 'general', '#'),
(12, 'Dhaddachaa Maatii', 'family', '#'),
(12, 'Dhaddachaa Yakkaa', 'criminal', '#');