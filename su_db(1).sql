-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Giu 18, 2019 alle 19:01
-- Versione del server: 10.1.31-MariaDB
-- Versione PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `su_db`
--

DELIMITER $$
--
-- Procedure
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `su_delete_notizia` (`_Cod` INT(3))  BEGIN
delete from notizia where Cod= _Cod;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_delete_report` (`_Cod` INT(2))  BEGIN
delete from reports where Cod = _Cod;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_delete_user` (`_Cod` INT(3))  BEGIN
DELETE FROM users where Cod = _Cod;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_delete_user_tags` (`_Username` VARCHAR(50))  BEGIN
update users set Preferenze = null where Username = _Username;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_insert_aula` (`_Aula` VARCHAR(20), `_Polo` VARCHAR(100), `_Locazione` VARCHAR(100))  BEGIN
insert into aule(Nome,Polo,Locazione) values (_Aula,_Polo,_Locazione);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_insert_notizia` (`_Titolo` VARCHAR(50), `_Contenuto` VARCHAR(1500), `_Categoria` TINYINT(2), `_Aula` VARCHAR(20), `_DataAppello` DATETIME, `_Tags` VARCHAR(100), `_Utente` VARCHAR(50))  BEGIN
if(_Categoria = 1) then
insert into notizia(Nome,Descrizione,Appello,Aula,DataAppello,Tags,Utente) values (_Titolo, _Contenuto,_Categoria,_Aula,_DataAppello,_Tags,_Utente);

else insert into notizia(Nome,Descrizione,Appello,Aula,DataAppello,Tags,Utente) values (_Titolo, _Contenuto,_Categoria,NULL,NULL,_Tags,_Utente);
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_insert_user` (`_Username` VARCHAR(50), `_Email` VARCHAR(100), `_Password` VARCHAR(255), `_Livello` TINYINT(2), `_VerCode` VARCHAR(255))  BEGIN
INSERT INTO users (Username, Email, Password,LivelloAutorizzativo, Ver_code) VALUES (_Username, _Email, _Password,_Livello, _VerCode);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_modify_utente` (`_Username` VARCHAR(50), `_Email` VARCHAR(100), `_Password` VARCHAR(255), `_LivelloAutorizzativo` TINYINT(2), `_VerCode` VARCHAR(255), `_Preferenze` VARCHAR(200), `_Operazione` VARCHAR(30))  BEGIN
IF (_Operazione = 'Cambio_email') then

UPDATE users SET Email = _Email, verified=0, Ver_code = _VerCode WHERE Username = _Username;

elseif (_Operazione = 'Elimina_utente') then

DELETE FROM users where Username = _Username;

elseif (_Operazione = 'Modifica_livello') then

UPDATE users set LivelloAutorizzativo = _LivelloAutorizzativo where Username = _Username;

elseif (_Operazione = 'Recupero_password') then

UPDATE users SET Password = _Password WHERE Email = _Email;

elseif (_Operazione = 'Modifica_password') then

UPDATE users SET Password = _Password, verified = 0, Ver_code = _VerCode WHERE Username = _Username;

elseif (_Operazione = 'Modifica_preferenze') then

UPDATE users set Preferenze = _Preferenze where Username = _Username;

else 

UPDATE users SET verified= 1 WHERE Email = _Email AND Ver_code = _VerCode;

end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_prenota` (`_Cod` TINYINT(2), `_Utente` VARCHAR(50), `_Polo` VARCHAR(100), `_DataInizio` DATETIME, `_DataFine` DATETIME)  BEGIN
insert into prenotazioni(Aula,Polo,DataInizio,DataFine,Utente) values (_Cod,_Polo,_DataInizio,_DataFine,_Utente);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_report` (`_Titolo` VARCHAR(50), `_Bug` VARCHAR(1500), `_Utente` VARCHAR(50))  BEGIN
insert into reports(Nome, Descrizione,Utente) values (_Titolo, _Bug, _Utente);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_select_aule` (`_Utente` VARCHAR(50), `_Polo` VARCHAR(100), `_DataInizio` DATETIME, `_DataFine` DATETIME)  BEGIN
if(_Utente = '') then
SELECT * FROM aule where Cod not in (select Aula from prenotazioni where (DataInizio >= _DataInizio and DataInizio < _DataFine) or (DataFine > _DataInizio and DataFine <= _DataFine)) and Polo =_Polo;


else select DISTINCT a.Nome as Aula,p.Polo as Polo,p.DataInizio as DataAppello,a.Locazione as Locazione from aule a, prenotazioni p where p.Utente = _Utente and a.Cod = p.Aula;

end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_select_bugs` ()  BEGIN
SELECT * FROM reports order by Data desc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_select_notizie` (`_Preferenze` VARCHAR(200))  BEGIN
if(_Preferenze = '') then
SELECT * from notizia;

else SELECT n.*
FROM tagmap bt, notizia n, tags t
WHERE bt.Id_tag = t.Id
AND (t.Nome IN (SELECT t2.Nome FROM (tags t2) WHERE FIND_IN_SET(t2.Nome, _Preferenze)))
AND n.Cod = bt.Id_notizia
GROUP BY n.Cod ORDER BY DataPubblicazione;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_select_poli` ()  BEGIN
SELECT distinct Polo from aule order by Polo ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_select_utenti` (`_Username` VARCHAR(50), `_Email` VARCHAR(100), `_Password` VARCHAR(255))  BEGIN
if(_Username != '' AND _Email = '' AND _Password = '') then

select Username,Email,Password,Preferenze,LivelloAutorizzativo,Refresh,Intervallo from users where Username = _Username;
/*Select per controllare che lo username o l'email non siano già presenti nel database*/
elseif(_Password = '' and (_Email != '' || _Username != '')) then

select Username,Email from users where Username = _Username or Email = _Email;

/*Select utilizzata per avere la lista di tutti gli utenti*/
elseif(_Username = '' AND _Email = '' AND _Password = '') then

select Cod,Username,Email,LivelloAutorizzativo from users;

end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `su_update_user` (`_Username` VARCHAR(50), `_Refresh` TINYINT(2), `_Intervallo` VARCHAR(50), `_Livello` TINYINT(2))  BEGIN
if(_Livello = '') then
update users set Refresh = _Refresh, Intervallo = _Intervallo where Username = _Username;

else  update users set LivelloAutorizzativo = _Livello where Username = _Username;

end if;
END$$

--
-- Funzioni
--
CREATE DEFINER=`root`@`localhost` FUNCTION `su_maxNotizia` () RETURNS INT(5) BEGIN

RETURN (
	select max(Cod) from notizia
  
);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struttura della tabella `aule`
--

CREATE TABLE `aule` (
  `Cod` int(3) NOT NULL,
  `Nome` varchar(20) NOT NULL,
  `Polo` varchar(100) NOT NULL,
  `Locazione` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `aule`
--

INSERT INTO `aule` (`Cod`, `Nome`, `Polo`, `Locazione`) VALUES
(2, 'AB1', 'Carla Lodovici', 'Via Madonna delle carceri'),
(4, 'AB2', 'Scienze naturali', 'Via Madonna delle Carceri'),
(1, 'LA1', 'Carla Lodovici', 'Via Madonna delle carceri'),
(3, 'LA1', 'Giachetti', 'Via Madonna delle Carceri');

-- --------------------------------------------------------

--
-- Struttura della tabella `notizia`
--

CREATE TABLE `notizia` (
  `Cod` int(11) NOT NULL,
  `Nome` varchar(50) DEFAULT NULL,
  `Descrizione` varchar(1500) NOT NULL,
  `Tags` varchar(100) NOT NULL,
  `DataPubblicazione` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Appello` tinyint(2) NOT NULL,
  `Aula` varchar(20) DEFAULT NULL,
  `DataAppello` datetime DEFAULT NULL,
  `Utente` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `notizia`
--

INSERT INTO `notizia` (`Cod`, `Nome`, `Descrizione`, `Tags`, `DataPubblicazione`, `Appello`, `Aula`, `DataAppello`, `Utente`) VALUES
(8, '', '', '', '2019-06-16 22:30:15', 1, 'AB1', '0000-00-00 00:00:00', 'mario.lombardi'),
(9, '', '', '', '2019-06-16 22:34:33', 0, NULL, NULL, 'mario.lombardi'),
(10, '', '', '', '2019-06-16 22:37:59', 0, NULL, NULL, 'mario.lombardi'),
(11, '', '', '', '2019-06-16 22:39:58', 0, NULL, NULL, 'mario.lombardi'),
(16, 'GFGFG', 'GFGFG', '#Informatica', '2019-06-18 11:26:25', 0, NULL, NULL, 'mario.lombardi'),
(17, 'GFGFG', 'GFGFG', '#Informatica', '2019-06-18 11:26:39', 0, NULL, NULL, 'mario.lombardi'),
(18, 'GFGFG', 'GFGFG', '', '2019-06-17 23:08:33', 0, NULL, NULL, 'mario.lombardi'),
(19, 'GFGFG', 'GFGFG', '', '2019-06-17 23:08:33', 0, NULL, NULL, 'mario.lombardi'),
(20, 'GFGFG', 'GFGFG', '', '2019-06-17 23:09:13', 0, NULL, NULL, 'mario.lombardi'),
(21, 'dgdgdg', 'dgdgdg', '', '2019-06-17 23:14:25', 0, NULL, NULL, 'mario.lombardi'),
(22, 'fsfdfdds', 'fdsfds', '', '2019-06-17 23:16:14', 1, 'AB1 ', '0000-00-00 00:00:00', 'mario.lombardi'),
(23, '', '', '', '2019-06-17 23:31:06', 1, 'AB1 ', '0000-00-00 00:00:00', 'mario.lombardi'),
(24, '', '', '', '2019-06-17 23:35:16', 1, 'AB1 ', '0000-00-00 00:00:00', 'mario.lombardi'),
(25, '', '', '', '2019-06-17 23:36:21', 1, 'AB1 ', '2019-06-27 01:36:12', 'mario.lombardi'),
(26, '', '', '#fgsfsfs,#fsfsf', '2019-06-18 11:23:40', 0, NULL, NULL, 'mario.lombardi');

-- --------------------------------------------------------

--
-- Struttura della tabella `prenotazioni`
--

CREATE TABLE `prenotazioni` (
  `Aula` int(3) NOT NULL,
  `Polo` varchar(100) NOT NULL,
  `DataInizio` datetime NOT NULL,
  `DataFine` datetime NOT NULL,
  `Utente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `prenotazioni`
--

INSERT INTO `prenotazioni` (`Aula`, `Polo`, `DataInizio`, `DataFine`, `Utente`) VALUES
(1, '', '2019-06-20 11:00:00', '2019-06-20 13:00:00', 'mario.lombardi'),
(2, '', '2019-06-20 11:00:00', '2019-06-20 13:00:00', 'mario.lombardi'),
(2, 'Carla Lodovici', '1970-01-01 01:00:00', '1970-01-01 02:00:00', 'mario.lombardi'),
(2, 'Carla Lodovici', '2019-06-19 11:00:00', '2019-06-19 13:00:00', 'mario.lombardi'),
(2, 'Carla Lodovici', '2019-06-20 13:38:35', '2019-06-20 15:38:35', 'mario.lombardi');

-- --------------------------------------------------------

--
-- Struttura della tabella `reports`
--

CREATE TABLE `reports` (
  `Cod` int(2) NOT NULL,
  `Nome` varchar(50) DEFAULT NULL,
  `Descrizione` varchar(1500) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Utente` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `reports`
--

INSERT INTO `reports` (`Cod`, `Nome`, `Descrizione`, `Data`, `Utente`) VALUES
(7, 'jjfj', 'fjfjf', '2019-06-18 11:41:37', 'mario.lombardi');

-- --------------------------------------------------------

--
-- Struttura della tabella `tagmap`
--

CREATE TABLE `tagmap` (
  `Id` int(11) NOT NULL,
  `Id_notizia` int(11) NOT NULL,
  `Id_tag` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tagmap`
--

INSERT INTO `tagmap` (`Id`, `Id_notizia`, `Id_tag`) VALUES
(2, 16, 2),
(3, 17, 13),
(4, 16, 12),
(5, 19, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `tags`
--

CREATE TABLE `tags` (
  `Id` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `tags`
--

INSERT INTO `tags` (`Id`, `Nome`) VALUES
(23, ''),
(15, '#aa'),
(30, '#fgsfsfs'),
(31, '#fsfsf'),
(14, '#gg'),
(29, '#grdgf'),
(12, '#Ids'),
(2, '#Informatica'),
(13, '#Lodovici'),
(1, '#Polini');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `Cod` int(3) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `LivelloAutorizzativo` tinyint(2) NOT NULL,
  `Verified` tinyint(2) NOT NULL,
  `Ver_code` varchar(255) DEFAULT NULL,
  `Preferenze` varchar(200) DEFAULT NULL,
  `Refresh` tinyint(2) NOT NULL DEFAULT '0',
  `Intervallo` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`Cod`, `Username`, `Email`, `Password`, `LivelloAutorizzativo`, `Verified`, `Ver_code`, `Preferenze`, `Refresh`, `Intervallo`) VALUES
(8, 'mario.lombardi', 'mario.lombardi@studenti.unicam.it', '$2y$10$NN9X.n9yib/cgW6TQE6uDuIRldgK9NZL2T.OQLR/oAvcDSRBvS.la', 3, 1, '$2y$10$mLiMqhfnU1n/pZXHXkdGmea9./p1r1wJIDxf/eBr7rb4ItqnhhQo6', '#Informatica', 0, '');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `aule`
--
ALTER TABLE `aule`
  ADD PRIMARY KEY (`Cod`),
  ADD KEY `Nome_2` (`Nome`,`Polo`,`Locazione`);

--
-- Indici per le tabelle `notizia`
--
ALTER TABLE `notizia`
  ADD PRIMARY KEY (`Cod`),
  ADD KEY `Aula` (`Aula`),
  ADD KEY `notizia_ibfk_3` (`Utente`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD PRIMARY KEY (`Aula`,`Polo`,`DataInizio`,`DataFine`,`Utente`) USING BTREE,
  ADD KEY `Utente` (`Utente`);

--
-- Indici per le tabelle `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`Cod`),
  ADD KEY `Utente` (`Utente`);

--
-- Indici per le tabelle `tagmap`
--
ALTER TABLE `tagmap`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `tagmap_ibfk_1` (`Id_notizia`),
  ADD KEY `tagmap_ibfk_2` (`Id_tag`);

--
-- Indici per le tabelle `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `Nome` (`Nome`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Cod`),
  ADD UNIQUE KEY `Username` (`Username`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `Preferenze` (`Preferenze`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `aule`
--
ALTER TABLE `aule`
  MODIFY `Cod` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `notizia`
--
ALTER TABLE `notizia`
  MODIFY `Cod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT per la tabella `reports`
--
ALTER TABLE `reports`
  MODIFY `Cod` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT per la tabella `tagmap`
--
ALTER TABLE `tagmap`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `tags`
--
ALTER TABLE `tags`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `Cod` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `notizia`
--
ALTER TABLE `notizia`
  ADD CONSTRAINT `notizia_ibfk_2` FOREIGN KEY (`Aula`) REFERENCES `aule` (`Nome`),
  ADD CONSTRAINT `notizia_ibfk_3` FOREIGN KEY (`Utente`) REFERENCES `users` (`Username`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE `prenotazioni`
  ADD CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`Aula`) REFERENCES `aule` (`Cod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `prenotazioni_ibfk_2` FOREIGN KEY (`Utente`) REFERENCES `users` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limiti per la tabella `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`Utente`) REFERENCES `users` (`Username`);

--
-- Limiti per la tabella `tagmap`
--
ALTER TABLE `tagmap`
  ADD CONSTRAINT `tagmap_ibfk_1` FOREIGN KEY (`Id_notizia`) REFERENCES `notizia` (`Cod`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tagmap_ibfk_2` FOREIGN KEY (`Id_tag`) REFERENCES `tags` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Eventi
--
CREATE DEFINER=`root`@`localhost` EVENT `eliminaNotizieObsolete` ON SCHEDULE EVERY 1 MONTH STARTS '2019-06-30 00:00:00' ON COMPLETION PRESERVE ENABLE DO delete from notizia where (month(CURRENT_DATE)-month(DataPubblicazione)) >= 3$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
