# Mitwirkung

Wir freuen uns über jeden, der sich am Projekt beteiligen möchte. Das können natürlich **Problemmeldungen** sein, vor allem aber schätzen wir **Problemlösungen** oder zumindest Ansätze und Vorschläge dazu.

# Probleme (Tickets)
Tritt ein Problem auf, sollte zuerst die Liste der bereits gemeldeten Probleme durchsucht werden, um Doppelungen zu vermeiden. Bevor das Problem gemeldet wird, sollte sichergestellt werden, dass die Testumgebung auf dem Stand der neuesten Revision ist und dass das Problem reproduzierbar ist.

## Notwendige Angaben

- **Titel und Beschreibung** (Bitte verwende Deutsch oder Englisch. Kurze, aber vollständige und eindeutige Angaben.)
- **Hash/Commit** (Bitte keine Angabe wie "aktueller Core". Damit ist schon bald nichts mehr anzufangen.)
- **IDs betroffener NPCs, Questen, Gegenstände usw.** (Bitte möglichst mit Link zu Ilaros, ersatzweise Wowhead.)

## Titel

- [Instanz] "Name" Kurzbeschreibung
- [Quest] "Name" (ID xxxx) Kurzbeschreibung
- [Kreatur] "Name" (ID xxxx) Kurzbeschreibung
- [Zauber] Quelle: "Name" (ID xxxx) Kurzbeschreibung
usw.

Quelle ist z.B. eine Klasse, eine Berufsfertigkeit oder ein NPC.

# Vorschläge (Pull Requests)
Vorschläge, die nur SQL enthalten, werden in Form eines Tickets eingebracht.
    [Ticket](https://help.github.com/articles/creating-an-issue/)

Für Vorschläge mit C++ oder anderen Projektbestandteilen gilt das Folgende.

1. Repositorium in eigenem Account auf GitHub forken.
    [Fork](https://help.github.com/articles/fork-a-repo/)
2. Einen Zweig (Branch) mit beliebigem Namen erstellen
    `git checkout -b name`
3. Änderungen einliefern (Commit)
    `git commit -am "Vorschlag"`
4. Änderungen hochladen (Push)
    `git push origin fixes`
5. Vorschlag in GitHub senden
    [Pull Request](https://help.github.com/articles/creating-a-pull-request/)

Sollen mehrere Beiträge vorgeschlagen werden, sollte für jeden Vorschlag ein eigener Zweig erstellt werden. So können mehrere Vorschläge zur gleichen Zeit aktiv sein, ohne jeweils auf das Zusammenführen (Merge) zu warten.

Für SQL-Dateien wird das Namensschema `JJJJ_MM_TT_i_database.sql` verwendet. Dabei ist `JJJJ_MM_TT` das Datum Jahr-Monat-Tag der Einfügung, `i` die laufende Nummer für einen Tag und `database` die Datenbank, auf die die SQL-Datei anzuwenden ist. Vorschläge sollten ein unmögliches Datum wie 9999_99_99_99_database.sql verwenden, so dass beim Eingepflegen keine Konflikte entstehen.