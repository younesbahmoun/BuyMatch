# BuyMatch
=============================================
 RÉSUMÉ DES DONNÉES DE TEST
 Base de données: buy_match
 Football Ticket System
=============================================

--------------------------------------------
 STATISTIQUES GÉNÉRALES
--------------------------------------------

| Table      | Nombre | Description                                      |
|------------|--------|--------------------------------------------------|
| roles      | 3      | admin, organisateur, client                      |
| users      | 12     | 2 admins, 3 organisateurs, 7 clients             |
| teams      | 10     | Équipes marocaines                               |
| stades     | 8      | Stades au Maroc                                  |
| matchs     | 9      | Différents statuts                               |
| categorys  | 27     | 3 catégories par match (VIP, Tribune, Pelouse)   |
| places     | 38     | Places pour quelques catégories                  |
| tickets    | 15     | Tickets vendus                                   |
| reviews    | 9      | Avis sur les matchs terminés                     |

--------------------------------------------
 DÉTAIL DES RÔLES
--------------------------------------------

1. admin        - Administrateur du système
2. organisateur - Organisateur de matchs
3. client       - Acheteur de tickets

--------------------------------------------
 DÉTAIL DES UTILISATEURS
--------------------------------------------

ADMINS (2):
  - Mohamed Alaoui      | admin@buymatch.ma
  - Fatima Bennani      | admin2@buymatch.ma

ORGANISATEURS (3):
  - Ahmed El Fassi      | org.raja@buymatch.ma
  - Karim Tazi          | org.wydad@buymatch.ma
  - Hassan Chraibi      | org.far@buymatch.ma

CLIENTS (7):
  - Youssef Malik       | youssef.malik@gmail.com
  - Sara Idrissi        | sara.idrissi@gmail.com
  - Omar Benjelloun     | omar.benjelloun@gmail.com
  - Leila Amrani        | leila.amrani@gmail.com
  - Hamza Kettani       | hamza.kettani@gmail.com (inactif)
  - Nadia Berrada       | nadia.berrada@gmail.com
  - Amine Lahlou        | amine.lahlou@gmail.com

--------------------------------------------
 DÉTAIL DES ÉQUIPES
--------------------------------------------

 1. Raja Club Athletic      | Casablanca
 2. Wydad Athletic Club     | Casablanca
 3. AS FAR                  | Rabat
 4. FUS Rabat               | Rabat
 5. MAS Fès                 | Fès
 6. Moghreb Tétouan         | Tétouan
 7. Renaissance Berkane     | Berkane
 8. Hassania Agadir         | Agadir
 9. Olympic Safi            | Safi
10. Chabab Mohammedia       | Mohammedia

--------------------------------------------
 DÉTAIL DES STADES
--------------------------------------------

1. Stade Mohammed V                  | Casablanca  | 67,000 places
2. Complexe Sportif Moulay Abdellah  | Rabat       | 52,000 places
3. Stade de Fès                      | Fès         | 45,000 places
4. Stade Saniat Rmel                 | Tétouan     | 35,000 places
5. Stade Municipal de Berkane        | Berkane     | 20,000 places
6. Stade Al Inbiaât                  | Agadir      | 45,000 places
7. Stade El Massira                  | Safi        | 20,000 places
8. Grand Stade de Marrakech          | Marrakech   | 45,000 places

--------------------------------------------
 DÉTAIL DES MATCHS
--------------------------------------------

TERMINÉS (2):
  Match 1: Raja vs Wydad          | 15/12/2024 20:00 | Stade Mohammed V
  Match 2: Wydad vs AS FAR        | 22/12/2024 18:00 | Stade Mohammed V

PUBLIÉS (2):
  Match 3: Raja vs MAS Fès        | 20/01/2025 20:00 | Stade Mohammed V
  Match 4: Wydad vs FUS Rabat     | 25/01/2025 18:00 | Stade Mohammed V

APPROUVÉ (1):
  Match 5: AS FAR vs RSB          | 01/02/2025 16:00 | Complexe Moulay Abdellah

EN ATTENTE (2):
  Match 6: Raja vs HUSA           | 10/02/2025 20:00 | Stade Mohammed V
  Match 7: MAT vs Wydad           | 15/02/2025 17:00 | Stade Saniat Rmel

REFUSÉ (1):
  Match 8: AS FAR vs OCS          | 10/01/2025 15:00 | Refusé - Date trop proche

ANNULÉ (1):
  Match 9: Raja vs SCM            | 08/01/2025 20:00 | Annulé

--------------------------------------------
 DÉTAIL DES CATÉGORIES (PAR MATCH)
--------------------------------------------

Chaque match possède 3 catégories:

  VIP      : 120-200 places  | Prix: 350-550 DH
  Tribune  : 480-800 places  | Prix: 100-180 DH
  Pelouse  : 600-1000 places | Prix: 35-60 DH

--------------------------------------------
 DÉTAIL DES PRIX
--------------------------------------------

             |   VIP   | Tribune | Pelouse |
-------------|---------|---------|---------|
Match 1      | 500 DH  | 150 DH  |  50 DH  |
Match 2      | 450 DH  | 120 DH  |  40 DH  |
Match 3      | 550 DH  | 180 DH  |  60 DH  |
Match 4      | 400 DH  | 130 DH  |  45 DH  |
Match 5      | 480 DH  | 140 DH  |  50 DH  |
Match 6      | 500 DH  | 150 DH  |  50 DH  |
Match 7      | 350 DH  | 100 DH  |  35 DH  |

--------------------------------------------
 DÉTAIL DES TICKETS VENDUS
--------------------------------------------

Match 1 (Raja vs Wydad) - 11 tickets:
  - VIP     : 4 tickets
  - Tribune : 4 tickets
  - Pelouse : 3 tickets

Match 3 (Raja vs MAS Fès) - 4 tickets:
  - VIP     : 2 tickets
  - Tribune : 1 ticket
  - Pelouse : 1 ticket

--------------------------------------------
 DÉTAIL DES REVIEWS
--------------------------------------------

Match 1 (Raja vs Wydad) - 5 avis:
  ★★★★★ (5/5) - Youssef Malik
  ★★★★☆ (4/5) - Sara Idrissi
  ★★★★★ (5/5) - Omar Benjelloun
  ★★★☆☆ (3/5) - Leila Amrani
  ★★★★★ (5/5) - Nadia Berrada

Match 2 (Wydad vs AS FAR) - 4 avis:
  ★★★★☆ (4/5) - Youssef Malik
  ★★★★☆ (4/5) - Amine Lahlou
  ★★★★★ (5/5) - Sara Idrissi
  ★★★☆☆ (3/5) - Omar Benjelloun

Note moyenne Match 1: 4.4/5
Note moyenne Match 2: 4.0/5

--------------------------------------------
 MOTS DE PASSE DE TEST
--------------------------------------------

Tous les utilisateurs ont le même hash de mot de passe pour les tests:
  Hash: $2y$10$abcdefghijklmnopqrstuv
  
Note: En production, chaque utilisateur doit avoir un mot de passe 
unique et sécurisé avec un hash bcrypt valide.

--------------------------------------------
 FIN DU RÉSUMÉ
--------------------------------------------