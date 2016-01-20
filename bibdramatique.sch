<?xml version="1.0" encoding="UTF-8"?>
<sch:schema 
  queryBinding="xslt"
  xmlns:sch="http://purl.oclc.org/dsdl/schematron"
  xmlns:sqf="http://www.schematron-quickfix.com/validator/process"
  xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
  >
  <sch:title>Contraintes spécifiques à la bibliothèque dramatique</sch:title>
  <sch:ns prefix="tei" uri="http://www.tei-c.org/ns/1.0"/>
  <xsl:key name="id" match="*" use="@xml:id"/>
  <xsl:key name="pb" match="tei:pb" use="concat(normalize-space(@ed), normalize-space(@n))"/>
  <sch:pattern>
    <sch:title>Bibliothèque dramatique, quelques règles pour augmenter la qualité</sch:title>
    <sch:rule context="tei:hi">
      <sch:report test="contains(@rend, 'indent')">hi est une balise de niveau caractère, l’indentation doit être portée par un bloc</sch:report>
    </sch:rule>
    <sch:rule context="tei:ref[starts-with(@target, '#')]">
      <sch:assert test="key('id', substring(@target, 2))"><sch:value-of select="substring(@target, 2)"/>, cet identifiant (@xml:id) n’existe pas dans le document</sch:assert>
    </sch:rule>
    <sch:rule context="tei:pb">
      <sch:report test="normalize-space(@n) = '' or not(@n)">Numéro de page manquant</sch:report>
      <sch:report test="count(key('pb', concat(normalize-space(@ed), normalize-space(@n)))) &gt; 1"><sch:value-of select="@n"/>, ce numéro de page semble dupliqué</sch:report>
      <sch:report test="local-name(following-sibling::*[1]) = 'div'">Il est conseillé de mettre un saut de page au début d’un div (plutôt qu’en dehors), de manière à faciliter le retour à la page</sch:report>
    </sch:rule>
    <sch:rule context="@target">
      <sch:report test="contains(., '. ') or contains(., ' ?') or contains(., ' :')">URL incorrecte, autour des signes de ponctuation</sch:report>
    </sch:rule>
  </sch:pattern>
</sch:schema>
