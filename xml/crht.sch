<?xml version="1.0" encoding="UTF-8"?>
<sch:schema xmlns:sch="http://purl.oclc.org/dsdl/schematron">
  <sch:title>Contraintes spécifiques à l’Astrée</sch:title>
  <sch:ns prefix="tei" uri="http://www.tei-c.org/ns/1.0" />  
  <sch:pattern>
      <sch:title>CRHT, quelques règles pour augmenter la qualité</sch:title>
      <sch:rule context="tei:hi">
         <sch:report test="contains(@rend, 'indent')">hi est une balise de niveau caractère, l’indentation doit être portée par un bloc</sch:report>
      </sch:rule>
      <sch:rule context="tei:pb">
         <sch:report test="local-name(following-sibling::*[1]) = 'div'">Il est conseillé de mettre un saut de page au début d’un div (plutôt qu’en dehors), de manière à faciliter le retour à la page</sch:report>
      </sch:rule>
   </sch:pattern>
</sch:schema>