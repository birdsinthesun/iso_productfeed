# Dokumentation zur Erweiterung Iso Productfeed

Die Contao-Erweiterung **Iso Productfeed** wurde entwickelt, um Produktdaten aus Isotope E-Commerce zu exportieren und beispielsweise für externe Marktplätze wie Meta (Facebook/Instagram) zu nutzen. Diese Anleitung erklärt die Konfiguration und die Nutzung der Erweiterung.

## 1. Konfigurationsmaske im Backend

Im Backend von Contao wird eine intuitive Konfigurationsmaske bereitgestellt, die es ermöglicht, den Produktfeed an die individuellen Anforderungen anzupassen. Hier können unter anderem folgende Einstellungen vorgenommen werden:
- Auswahl der zu exportierenden Produkteigenschaften, z. B. Name, Beschreibung, Preis oder individuelle Attribute.
- Zuordnung spezifischer Felder von Isotope zu den Attributen im XML-Feed, um sicherzustellen, dass diese korrekt ausgegeben werden.

## 2. Detailseite und XML-Link

Die Erweiterung ermöglicht es, die URL der Detailseite zu konfigurieren, die in der generierten XML-Datei ausgegeben wird. Diese Detailseite ist in den Shop-Konfigurationen auswählbar und muss dort explizit eingestellt werden.

**Wichtig:** Auf der ausgewählten Detailseite muss zudem die passende Shop-Konfiguration zugeordnet werden. Nur so ist gewährleistet, dass die XML-Datei korrekt generiert wird und die Verlinkung zu den Produkten im Shop einwandfrei funktioniert.

## 3. Währung und Preisformat

Für den erfolgreichen Einsatz auf Plattformen wie Meta ist es wichtig, dass die Währung und das Preisformat korrekt angegeben werden. Die Erweiterung generiert die XML-Datei automatisch in dem geforderten Format, z. B.:
- Preis: `19.99` (mit Punkt statt Komma)
- Währung: `EUR`

## 4. Auswahl der Shop-Konfiguration

In der Konfigurationsmaske kannst du die gewünschte Shop-Konfiguration für den Feed festlegen. Diese Einstellung ist entscheidend für die richtige Preisberechnung, insbesondere wenn mehrere Konfigurationen in Isotope verwendet werden.

## 5. Isotope-Attribute

Isotope E-Commerce liefert bereits eine Vielzahl von Eigenschaften, die in den Produkten hinterlegt sind. Dazu gehören unter anderem:
- Produktname
- Beschreibung
- Bild
- Preis

Ein wichtiges Attribut, das Isotope jedoch nicht standardmäßig mitbringt, ist **Availability** (Verfügbarkeit). Dieses Attribut wird jedoch von der XML-Datei gefordert, um die Anforderungen externer Plattformen wie Meta zu erfüllen.

Zusätzlich wird ein weiteres Attribut benötigt, wenn Produkte mit einem reduzierten Preis ausgezeichnet sind. Hierbei muss ein Attribut mit dem Feldnamen **Sale-Preis** (reduzierter Preis) in Isotope angelegt werden. Dieses Attribut stellt sicher, dass sowohl der ursprüngliche Preis als auch der reduzierte Preis korrekt im XML-Feed ausgegeben werden.

**Wichtig:** Beide Attribute – **Availability** und **Sale-Preis** – müssen manuell in Isotope erstellt und den Produkten zugewiesen werden, damit sie ordnungsgemäß im Produktfeed erscheinen.

## 6. Aktuelle Einschränkungen

Die Erweiterung unterstützt derzeit keine Variantenprodukte oder Mehrsprachigkeit. Wenn diese Funktionen in deinem Shop eine Rolle spielen, können sie momentan nicht in den XML-Export eingebunden werden.

## Fazit

Mit der Erweiterung **Iso Productfeed** kannst du deine Produktdaten effizient und konform mit den Anforderungen von Plattformen wie Meta exportieren. Dank der flexiblen Konfiguration ist die Anpassung an verschiedene Bedürfnisse einfach möglich, auch wenn die Erweiterung aktuell noch einige Einschränkungen aufweist.

Falls du weitere Fragen hast, steht dir die Dokumentation oder der Support zur Verfügung.
