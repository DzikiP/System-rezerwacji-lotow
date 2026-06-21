# Dokumentacja projektu

## Spis treści

1. Strona tytułowa
2. Słownik
3. Cel i zakres projektu
4. Architektura systemu
5. Wymagania
    - 5.1 Wymagania funkcjonalne
    - 5.2 Wymagania niefunkcjonalne
6. Ograniczenia

### Dokumentacja projektowa

7. Użytkownicy
8. Przypadki użycia
9. Baza danych
10. Diagramy sekwencji
11. Diagramy aktywności
12. Diagramy stanów
13. Dokumentacja bezpieczeństwa
14. Dostępność (WCAG)

### Dokumentacja deweloperska

15. Diagram klas
16. Kod SQL
17. Przypadki testowe
18. Testy jednostkowe

### Dokumentacja techniczna

19. Diagram komponentów i wdrożenia
20. Instalacja i konfiguracja
21. Implementacja mechanizmów bezpieczeństwa

### Dokumentacja użytkownika

22. Podręcznik użytkownika

# System Rezerwacji Lotów

**Nazwa projektu:** System Rezerwacji Lotów

**Skrót projektu:** FlightBookingSystem

**Autorzy:**
- Patryk
- Denis Stefański

**Repozytorium projektu:**
https://github.com/DzikiP/System-rezerwacji-lotow

**Technologie:**
- Laravel 12
- PHP 8.2
- PostgreSQL
- Blade
- Tailwind CSS
- Docker

## 2. Słownik

Poniżej przedstawiono podstawowe pojęcia używane w dokumentacji oraz w systemie.

### Użytkownik
Osoba korzystająca z systemu. Może przeglądać loty, rezerwować je oraz zarządzać swoimi rezerwacjami po zalogowaniu.

### Gość
Niezalogowany użytkownik systemu, który ma dostęp jedynie do przeglądania i wyszukiwania lotów.

### Rezerwacja
Zapis w systemie reprezentujący wybór konkretnego lotu przez użytkownika wraz z jego danymi.

### Lot
Pojedyncze połączenie lotnicze pobierane z zewnętrznego API, zawierające informacje takie jak trasa, godziny oraz cena.

### API
Interfejs programistyczny umożliwiający komunikację z zewnętrznym systemem dostarczającym dane o lotach.

### Laravel
Framework backendowy w języku PHP wykorzystywany do implementacji logiki aplikacji oraz obsługi żądań HTTP.

### Blade
Silnik szablonów używany w Laravelu do generowania dynamicznych widoków HTML.

### PostgreSQL
Relacyjny system zarządzania bazą danych wykorzystywany do przechowywania danych aplikacji, takich jak użytkownicy i rezerwacje.

### Migracja
Mechanizm w Laravelu pozwalający na wersjonowanie i automatyczne tworzenie struktury bazy danych.

### Model
Klasa w architekturze MVC reprezentująca dane oraz logikę operacji na nich (np. użytkownik, rezerwacja).

### Kontroler
Warstwa aplikacji odpowiedzialna za obsługę żądań użytkownika oraz komunikację między widokiem a modelem.

### Widok
Warstwa prezentacji w architekturze MVC odpowiedzialna za interfejs użytkownika.

### CRUD
Zestaw operacji: Create, Read, Update, Delete, czyli podstawowe operacje wykonywane na danych w systemie.

### Docker
Narzędzie do konteneryzacji aplikacji, umożliwiające jej uruchamianie w izolowanym środowisku.

### Railway
Platforma chmurowa wykorzystywana do wdrożenia (deploymentu) aplikacji.

# 1. Wstęp

## 1.1 Cel projektu

Celem projektu jest zaprojektowanie i implementacja aplikacji internetowej umożliwiającej wyszukiwanie połączeń lotniczych oraz zarządzanie rezerwacjami biletów lotniczych.

System umożliwia użytkownikom przeglądanie dostępnych lotów, ich wyszukiwanie na podstawie określonych parametrów oraz tworzenie i zarządzanie rezerwacjami.

---

## 1.2 Przyczyna podjęcia realizacji projektu

Główną przyczyną realizacji projektu jest potrzeba informatyzacji procesu wyszukiwania i rezerwacji lotów.

Współczesne systemy rezerwacyjne wymagają szybkiego dostępu do danych oraz intuicyjnego interfejsu użytkownika. Zastosowanie aplikacji webowej umożliwia:

- uproszczenie procesu wyszukiwania lotów,
- centralizację danych o rezerwacjach użytkowników,
- zwiększenie wygody użytkowników poprzez dostęp do systemu z poziomu przeglądarki internetowej,
- automatyzację procesu zarządzania rezerwacjami.

---

## 1.3 Opis oprogramowania

Oprogramowanie realizuje proces wyszukiwania oraz rezerwacji lotów.

Użytkownik może wyszukiwać loty na podstawie miejsca wylotu, miejsca docelowego oraz daty. System integruje się z zewnętrznym API dostarczającym dane o dostępnych połączeniach lotniczych.

Dodatkowo aplikacja umożliwia:
- tworzenie kont użytkowników,
- logowanie i autoryzację,
- tworzenie rezerwacji lotów,
- przegląd i zarządzanie rezerwacjami,
- edycję oraz usuwanie rezerwacji.

System przechowuje dane użytkowników oraz rezerwacji w relacyjnej bazie danych PostgreSQL.

---

## 1.4 Ograniczenia

* Aplikacja działa wyłącznie w przeglądarce internetowej  
* System wymaga aktywnego połączenia z Internetem  
* Dane o lotach zależą od dostępności zewnętrznego API  
* Brak integracji z systemami płatności online  
* System nie gwarantuje rzeczywistej dostępności miejsc w czasie rzeczywistym  
* Aplikacja została zaprojektowana w architekturze MVC (Laravel)  
* System działa w środowisku PHP 8.2  
* Wymagana baza danych: PostgreSQL

---

## 1.5 Architektura

Aplikacja została zbudowana w oparciu o architekturę MVC (Model–View–Controller).

System składa się z następujących warstw:

- **Warstwa prezentacji (View)** – interfejs użytkownika oparty o Blade i Tailwind CSS
- **Warstwa kontrolerów (Controller)** – obsługa żądań HTTP oraz logika przepływu aplikacji
- **Warstwa modelu (Model)** – reprezentacja danych oraz komunikacja z bazą danych
- **Warstwa zewnętrznych usług (API)** – integracja z zewnętrznym API lotów
- **Warstwa bazy danych** – PostgreSQL przechowujący dane użytkowników i rezerwacji

---

## 1.6 Link do działającej aplikacji

Aplikacja działająca: *system-rezerwacji-lotow-production.up.railway.app*

:contentReference[oaicite:0]{index=0}

---

# 2. Wymagania funkcjonalne

- System umożliwia wyszukiwanie dostępnych lotów na podstawie miejsca wylotu, miejsca docelowego oraz daty.
- System umożliwia przeglądanie wyników wyszukiwania lotów przez użytkowników niezalogowanych.
- System umożliwia rejestrację użytkownika.
- System umożliwia logowanie użytkownika do systemu.
- System umożliwia tworzenie rezerwacji wybranego lotu przez zalogowanego użytkownika.
- System umożliwia przegląd listy rezerwacji użytkownika.
- System umożliwia edycję oraz usuwanie rezerwacji.
- System przechowuje historię rezerwacji użytkownika.
- System umożliwia wylogowanie użytkownika.
- System integruje się z zewnętrznym API dostarczającym dane o lotach.

---

# 3. Wymagania niefunkcjonalne

## Interfejs

- Aplikacja działa jako strona internetowa (web application).
- Interfejs użytkownika jest responsywny (RWD).
- Interfejs został wykonany z użyciem Tailwind CSS.
- System zapewnia spójny wygląd wszystkich widoków.

---

## Dostępność i niezawodność

- System działa w trybie 24/7.
- System wymaga połączenia z Internetem.
- System jest kompatybilny z popularnymi przeglądarkami (Chrome, Edge, Firefox).
- Aplikacja działa poprawnie na urządzeniach mobilnych i desktopowych.

---

## Wydajność

- Czas odpowiedzi systemu na podstawowe zapytania nie przekracza 1–2 sekund.
- System jest w stanie obsłużyć wielu równoczesnych użytkowników (ograniczone zasobami hostingu).

---

## Bezpieczeństwo

- Hasła użytkowników są przechowywane w postaci zaszyfrowanej (hash).
- Dostęp do funkcji systemu wymaga autoryzacji.
- System chroni dane użytkowników przed nieautoryzowanym dostępem.
- Komunikacja odbywa się przez bezpieczny protokół HTTPS (w środowisku produkcyjnym).
- Dane sesyjne są chronione przed nieautoryzowanym dostępem.

---

# 4. Dokumentacja projektowa

## 4.1 Użytkownicy

### Gość (Guest)
Niezalogowany użytkownik systemu. Może przeglądać oraz wyszukiwać loty, ale nie ma możliwości dokonywania rezerwacji.

### Użytkownik (User)
Zalogowany użytkownik systemu. Może wyszukiwać loty, tworzyć rezerwacje oraz zarządzać swoimi rezerwacjami.

### Administrator (opcjonalnie – jeśli masz)
Użytkownik posiadający pełne uprawnienia do zarządzania systemem, użytkownikami oraz rezerwacjami.

---

## 4.2 Przypadki użycia

System umożliwia realizację procesów związanych z wyszukiwaniem lotów oraz zarządzaniem rezerwacjami.

### Aktorzy systemu

- **Gość (Guest)** – użytkownik niezalogowany
- **Użytkownik (User)** – użytkownik zalogowany
- **System zewnętrzny (API lotów)** – dostarcza dane o lotach

W systemie zidentyfikowano następujące przypadki użycia:

| ID | Przypadek użycia | Aktor |
|----|------------------|--------|
| UC-01 | Rejestracja użytkownika | Gość |
| UC-02 | Logowanie do systemu | Użytkownik |
| UC-03 | Wylogowanie z systemu | Użytkownik |
| UC-04 | Wyszukiwanie lotów | Gość, Użytkownik |
| UC-05 | Wyświetlenie szczegółów lotu | Gość, Użytkownik |
| UC-06 | Utworzenie rezerwacji lotu | Użytkownik |
| UC-07 | Wyświetlenie listy rezerwacji | Użytkownik |
| UC-08 | Edycja rezerwacji | Użytkownik |
| UC-09 | Usunięcie (anulowanie) rezerwacji | Użytkownik |
| UC-10 | Zarządzanie kontem użytkownika | Użytkownik |

## Diagram przypadków użycia

![Diagram przypadków użycia](docs/images/use-case.png)
**Rys 1. Diagram przypadków użycia systemu rezerwacji lotów**

---

## 4.2.2 Tabele scenariuszy przypadków użycia

---

### Rejestracja nowego użytkownika

| Element | Opis |
|--------|------|
| Cel w kontekście systemu | Umożliwienie użytkownikowi utworzenia konta w systemie rezerwacji lotów |
| Warunki wstępne | Użytkownik posiada dostęp do Internetu oraz aktywny adres e-mail |
| Warunek pomyślnego zakończenia | Konto użytkownika zostaje utworzone i aktywowane |
| Stan końcowy – niepowodzenie | Rejestracja nie zostaje ukończona z powodu błędnych danych lub braku aktywacji konta |
| Główni aktorzy | Użytkownik |
| Aktorzy współuczestniczący | System rezerwacji lotów, serwer poczty e-mail |
| Wywołanie (inicjacja) | Użytkownik wybiera opcję „Zarejestruj się” |
| Include | Walidacja danych, wysyłka e-maila aktywacyjnego |
| Extend | Logowanie po aktywacji konta |
| Scenariusz główny | 1. Użytkownik otwiera formularz rejestracji <br> 2. Wprowadza dane (email, hasło, imię, nazwisko) <br> 3. System waliduje dane <br> 4. System zapisuje użytkownika <br> 5. System wysyła e-mail aktywacyjny <br> 6. Użytkownik aktywuje konto |
| Scenariusze alternatywne | A1: Błędne dane – system wyświetla komunikat błędu <br> A2: Brak aktywacji – konto nie zostaje aktywowane |

---

### Logowanie do systemu

| Element | Opis |
|--------|------|
| Cel w kontekście systemu | Umożliwienie użytkownikowi zalogowania się do systemu |
| Warunki wstępne | Konto użytkownika istnieje i jest aktywne |
| Warunek pomyślnego zakończenia | Użytkownik uzyskuje dostęp do konta |
| Stan końcowy – niepowodzenie | Logowanie nie powiodło się (błędne dane lub nieaktywne konto) |
| Główni aktorzy | Użytkownik |
| Aktorzy współuczestniczący | System rezerwacji lotów, baza danych |
| Wywołanie (inicjacja) | Użytkownik wybiera „Zaloguj się” |
| Include | Weryfikacja danych logowania |
| Extend | Reset hasła |
| Scenariusz główny | 1. Użytkownik wpisuje login i hasło <br> 2. System weryfikuje dane <br> 3. System tworzy sesję <br> 4. Użytkownik zostaje zalogowany |
| Scenariusze alternatywne | A1: Błędne dane – komunikat o błędzie <br> A2: Konto nieaktywne – brak dostępu |

---

### Wyszukiwanie lotów

| Element | Opis |
|--------|------|
| Cel w kontekście systemu | Umożliwienie wyszukiwania dostępnych lotów |
| Warunki wstępne | Użytkownik ma dostęp do wyszukiwarki |
| Warunek pomyślnego zakończenia | System wyświetla listę dostępnych lotów |
| Stan końcowy – niepowodzenie | Brak wyników lub błąd API |
| Główni aktorzy | Użytkownik |
| Aktorzy współuczestniczący | Zewnętrzne API lotów |
| Wywołanie (inicjacja) | Użytkownik wprowadza parametry wyszukiwania |
| Include | Pobieranie danych z API, filtrowanie wyników |
| Extend | Rezerwacja lotu, szczegóły lotu |
| Scenariusz główny | 1. Użytkownik wpisuje kryteria wyszukiwania <br> 2. System wysyła zapytanie do API <br> 3. API zwraca dane <br> 4. System wyświetla wyniki |
| Scenariusze alternatywne | A1: Brak wyników – komunikat <br> A2: Błąd API – ponowienie zapytania |

---

### Rezerwacja lotu

| Element | Opis |
|--------|------|
| Cel w kontekście systemu | Utworzenie rezerwacji wybranego lotu |
| Warunki wstępne | Użytkownik wybrał lot i jest zalogowany |
| Warunek pomyślnego zakończenia | Rezerwacja zostaje zapisana w systemie |
| Stan końcowy – niepowodzenie | Rezerwacja anulowana lub nieukończona |
| Główni aktorzy | Użytkownik |
| Aktorzy współuczestniczący | System rezerwacji lotów |
| Wywołanie (inicjacja) | Użytkownik wybiera „Zarezerwuj” |
| Include | Walidacja danych, zapis rezerwacji |
| Extend | Anulowanie rezerwacji |
| Scenariusz główny | 1. Użytkownik wybiera lot <br> 2. System pokazuje szczegóły <br> 3. Użytkownik potwierdza <br> 4. System zapisuje rezerwację |
| Scenariusze alternatywne | A1: Brak logowania – przekierowanie do logowania |

---

### Zarządzanie kontem

| Element | Opis |
|--------|------|
| Cel w kontekście systemu | Zarządzanie danymi użytkownika i jego rezerwacjami |
| Warunki wstępne | Użytkownik jest zalogowany |
| Warunek pomyślnego zakończenia | Dane zostają zaktualizowane |
| Stan końcowy – niepowodzenie | Brak uprawnień lub błąd systemu |
| Główni aktorzy | Użytkownik |
| Aktorzy współuczestniczący | System rezerwacji lotów |
| Wywołanie (inicjacja) | Użytkownik otwiera panel konta |
| Include | Edycja danych, przegląd rezerwacji |
| Extend | Anulowanie rezerwacji |
| Scenariusz główny | 1. Użytkownik otwiera konto <br> 2. System wyświetla dane <br> 3. Użytkownik edytuje dane lub rezerwacje <br> 4. System zapisuje zmiany |
| Scenariusze alternatywne | A1: Brak uprawnień – komunikat <br> A2: Błąd zapisu – ponowienie operacji |

## 4.2 Diagramy czynności

* Rejestracja użytkownika 
* Logowanie do systemu
* Wyszukiwanie lotów 
* Rezerwacja lotu
* Edycja rezerwacji
* Anulowanie rezerwacji
* Zarządzanie kontem użytkownika

### Wyszukiwanie
![Diagram czynności wyszukiwania](docs/images/wyszukiwanie.png)
**Rys. 2 diagram czynności wyszukiwania**

### Rezerwacja
![Diagram czynności rezerwacje](docs/images/rezerwacja.png)
**Rys. 3 diagram czynności rezerwacja**

## 4.3 Modele bazy danych

### Model koncepcyjny bazy danych

### Encje:

- Użytkownik (User)
- Rola (Role)
- Rezerwacja (Booking)
- Pasażer (Passenger)
- Bilet (Ticket)
- Płatność (Payment)
- Lotnisko (Airport)

### Relacje:

- Rola przypisana jest do wielu użytkowników (1:N)
- Użytkownik może posiadać wiele rezerwacji (1:N)
- Rezerwacja zawiera wielu pasażerów (1:N)
- Rezerwacja może mieć jedną płatność (1:0..1)
- Rezerwacja może generować jeden bilet (1:0..1)
- Lotnisko funkcjonuje jako encja referencyjna (bez relacji w aktualnej wersji systemu)

Model koncepcyjny odzwierciedla strukturę systemu z punktu widzenia biznesowego.


Model bazy danych został zaprojektowany z wyłączeniem kolumny flight_data, która została celowo zdenormalizowana w celu przechowywania danych pochodzących z zewnętrznego API w formacie JSON.

Tabela `airports` pełni rolę słownika referencyjnego zawierającego dane o lotniskach (IATA, ICAO, nazwa, lokalizacja).

W aktualnej architekturze systemu tabela nie posiada relacji z innymi encjami, ponieważ dane o lotach są pobierane z zewnętrznego API i przechowywane w formie JSON w kolumnie `flight_data` tabeli `bookings`.

Tabela może być wykorzystywana jako cache lub źródło danych pomocniczych w procesie wyszukiwania lotów.

## Model logiczny bazy danych

![Model logiczny bazy danych](docs/images/logical.png)
**Rys. 4 Model logiczny bazy danych systemu rezerwacji lotów**

## Model fizyczny bazy danych

![Model fizyczny bazy danyc](docs/images/relational_1.png)
**Rys. 5 Model logiczny bazy danych systemu rezerwacji lotów**

## 4.4 Diagramy stanów

* Stan rezerwacji
* Stan płatności
* Stan biletu
* konta użytkownika

### Logowanie
![Diagramy stanu logowania](docs/images/logowanie_state.png)
**Rys. 6 Diagram stanu logowania**

### Rejestracja
![Diagramy stanu rejestracji](docs/images/rejestracja_state.png)
**Rys. 7 Diagram stanu rejestracji**

### Rezerwacja
![Diagramy stanu rezerwacji](docs/images/rezerwacja_state.png)
**Rys. 8 Diagram stanu rezerwacji**

## 4.5 Diagramy sekwencji

* Rejestracja użytkownika
* Logowanie do systemu
* Wyszukiwanie lotów
* Rezerwacja lotu
* Edycja rezerwacji
* Anulowanie rezerwacji
* Generowanie biletu

### Rezerwacja lotu
![Diagram sekwencji rejestracji](docs/images/rezerwacja_sekwencja.png)
**Rys. 9 Diagram sekwencji rejestracji**

### wyszukiwanie lotów
![Diagram sekwencji wyszukiwania](docs/images/wyszukiwanie_sekwencja.png)
**Rys. 10 Diagram sekwencji wyszukiwania**

## 5. Dokumentacja bezpieczeństwa systemu

### 5.1 Bezpieczeństwo danych w bazie
* Hasła użytkowników są przechowywane jako hash (bcrypt).
* Dane w bazie są chronione przez kontrolę dostępu i uprawnienia (RBAC).
* Dostęp do danych ograniczony jest zasadą least privilege.
* Dane rezerwacji i pasażerów są powiązane kluczami obcymi, co ogranicza dostęp nieautoryzowany.

### 5.2 Bezpieczeństwo transmisji danych
* Komunikacja odbywa się przez HTTPS (TLS).
* Dane logowania przesyłane są metodą POST.
* System nie przekazuje danych w URL.
* Integracje z API zewnętrznymi również korzystają z HTTPS.

### 5.3 Secure by Design
* walidacja danych wejściowych,
* ochrona przed SQL Injection (Eloquent ORM),
* ochrona przed XSS),
* kontrola dostępu oparta o role (admin/user),
* separacja logiki w architekturze MVC. 

### 5.4 Privacy by Design
* zbierane są tylko niezbędne dane użytkowników,
* dane pasażerów ograniczone do minimum,
* brak udostępniania danych podmiotom trzecim poza API,
* użytkownik ma kontrolę nad swoimi danymi.

### 5.5 Zero Trust
* każde żądanie jest weryfikowane niezależnie,
* system nie ufa danym z frontendu,
* dostęp zależy od ról i uprawnień,

## 6. Rozwiązania zwiększające dostępność (WCAG)
System w podstawowym zakresie spełnia wymagania WCAG 2.1 na poziomie A, 
z częściowym uwzględnieniem poziomu AA, w szczególności w zakresie czytelności, nawigacji oraz obsługi klawiaturą.

# Dokumentacja deweloperska

## 7. Diagram klas
![Diagram klas](docs/images/diagram_klas.png)
**Rys. 11 Diagram klas**

## 8. Kod SQL

### Standard SQL do tworzenia modelu bazy danych

Model bazy danych został zaimplementowany przy użyciu migracji frameworka Laravel. Migracje definiują strukturę tabel, klucze główne, klucze obce oraz ograniczenia integralności danych.

Pełny kod SQL modelu bazy danych znajduje się w katalogu `database/migrations` repozytorium projektu.

Repozytorium projektu:
https://github.com/DzikiP/System-rezerwacji-lotow

Poniżej przedstawiono przykładową definicję tabeli `users`.

```sql
CREATE TABLE roles (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL
);

CREATE TABLE users (
    id BIGSERIAL PRIMARY KEY,
    role_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),

    CONSTRAINT fk_users_role
        FOREIGN KEY (role_id)
        REFERENCES roles(id)
);
```
### Dialekt SQL

Projekt wykorzystuje bazę danych PostgreSQL, dlatego zastosowany został dialekt PostgreSQL SQL.

W warstwie aplikacji dostęp do bazy danych realizowany jest za pomocą ORM Eloquent dostarczanego przez framework Laravel.
Struktura bazy definiowana jest przy użyciu migracji Laravel, które podczas wykonywania generują odpowiedni kod SQL zgodny z dialektem PostgreSQL.

## Przypadki testowe

### Przypadek testowy 1 – Logowanie użytkownika

| Pole | Opis |
|------|------|
| **Nazwa** | Logowanie użytkownika |
| **Cel** | Sprawdzenie poprawności logowania użytkownika do systemu. |
| **Warunki wstępne** | Użytkownik posiada aktywne konto w systemie. |
| **Dane testowe** | E-mail: `test@test.pl`<br>Hasło: `password123` |
| **Kroki** | 1. Otwórz stronę logowania.<br>2. Wprowadź poprawny adres e-mail i hasło.<br>3. Kliknij przycisk **Zaloguj**. |
| **Oczekiwany rezultat** | Użytkownik zostaje zalogowany i przekierowany do panelu głównego. |
| **Wynik testu** | Pozytywny |

---

### Przypadek testowy 2 – Utworzenie rezerwacji lotu

| Pole | Opis |
|------|------|
| **Nazwa** | Utworzenie rezerwacji lotu |
| **Cel** | Sprawdzenie poprawności procesu tworzenia rezerwacji. |
| **Warunki wstępne** | Użytkownik jest zalogowany. Wyszukano dostępny lot. |
| **Dane testowe** | Dane pasażera oraz wybrany lot. |
| **Kroki** | 1. Wyszukaj lot.<br>2. Wybierz ofertę.<br>3. Wprowadź dane pasażera.<br>4. Wprowadź dane kontaktowe.<br>5. Potwierdź rezerwację. |
| **Oczekiwany rezultat** | Rezerwacja zostaje zapisana w bazie danych, a użytkownik otrzymuje numer rezerwacji. |
| **Wynik testu** | Pozytywny |

## Testy jednostkowe

### Test jednostkowy 1 – Tworzenie użytkownika

**Cel:** Sprawdzenie poprawności utworzenia nowego użytkownika.

**Plik:** `tests/Unit/UserTest.php`

```php
<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created(): void
    {
        $role = Role::create([
            'name' => 'user'
        ]);

        $user = User::create([
            'role_id' => $role->id,
            'name' => 'Jan Kowalski',
            'email' => 'jan@test.pl',
            'password' => bcrypt('password123'),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'jan@test.pl'
        ]);

        $this->assertEquals('Jan Kowalski', $user->name);
    }
}


```

### Wynik testu
![wynik UserTest](docs/images/UserTest.png)

### Test jednostkowy 2 – Status nowej rezerwacji

**Cel:** Sprawdzenie, czy nowa rezerwacja otrzymuje poprawny status.

**Plik:** `tests/Unit/BookingTest.php`

```php
<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Role;
use App\Models\Booking;
use App\Enums\BookingStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_is_created_with_pending_status(): void
    {
        $role = Role::create([
            'name' => 'user'
        ]);

        $user = User::create([
            'role_id' => $role->id,
            'name' => 'Test User',
            'email' => 'test@test.pl',
            'password' => bcrypt('password'),
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'booking_reference' => 'REF123',
            'status' => BookingStatus::PENDING,
            'passengers_count' => 1,
            'total_price' => 100,
            'currency' => 'USD',
        ]);

        $this->assertDatabaseHas('bookings', [
            'booking_reference' => 'REF123',
        ]);

        $this->assertEquals(BookingStatus::PENDING, $booking->status);
    }
}

```

### Wynik testu
![wynik BookingTest](docs/images/BookingTest.png)

## Testy integracyjne

Testy integracyjne zostały przygotowane w celu weryfikacji współpracy wielu komponentów systemu, takich jak modele, warstwa ORM (Eloquent) oraz baza danych.

Testy realizowane są z wykorzystaniem frameworka PHPUnit w środowisku Laravel oraz korzystają z mechanizmu `RefreshDatabase`, który zapewnia czyste środowisko testowe dla każdego uruchomienia.

### Zakres testów integracyjnych

W ramach testów integracyjnych sprawdzono następujące scenariusze:

- tworzenie rezerwacji przez użytkownika systemu,
- poprawność relacji pomiędzy użytkownikiem a rezerwacjami.

---

### Test 1 – Tworzenie rezerwacji

Test sprawdza możliwość utworzenia rezerwacji powiązanej z użytkownikiem oraz poprawne zapisanie danych w bazie.

```php
public function test_user_can_create_booking(): void
    {
        $role = Role::create([
            'name' => 'user'
        ]);

        $user = User::create([
            'role_id' => $role->id,
            'name' => 'Integration User',
            'email' => 'integration@test.pl',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $booking = Booking::create([
            'user_id' => $user->id,
            'booking_reference' => 'INT-001',
            'status' => 'pending',
            'passengers_count' => 2,
            'total_price' => 500,
            'currency' => 'USD',
        ]);

        // 5. assertions
        $this->assertDatabaseHas('bookings', [
            'booking_reference' => 'INT-001',
        ]);

        $this->assertEquals($user->id, $booking->user_id);
    }
```
---

### Test 2 – Relacja użytkownik → rezerwacje

Test weryfikuje poprawność relacji pomiędzy użytkownikiem a rezerwacjami.

```php
public function test_user_bookings_relationship(): void
{
    $role = Role::create(['name' => 'user']);

    $user = User::create([
        'role_id' => $role->id,
        'name' => 'Relation User',
        'email' => 'relation@test.pl',
        'password' => bcrypt('password'),
    ]);

    Booking::create([
        'user_id' => $user->id,
        'booking_reference' => 'REL-001',
        'status' => 'pending',
        'passengers_count' => 1,
        'total_price' => 100,
        'currency' => 'USD',
    ]);

    $this->assertCount(1, $user->fresh()->bookings);
}
```
### Wynik testów integracyjnych
![wynik testów integracyjnych](docs/images/TestyIntegracyjne.png)

#Dokumentacja techniczna

## Instalacja i konfiguracja:

### Continuous Integration i Continuous Deployment (CI/CD)

Projekt wykorzystuje GitHub Actions do automatycznego uruchamiania procesu Continuous Integration. Po każdym przesłaniu zmian do gałęzi `main` wykonywane są testy jednostkowe i integracyjne.

Platforma Railway została skonfigurowana z opcją **Wait for CI**, dzięki czemu nowe wdrożenie następuje wyłącznie po pomyślnym zakończeniu wszystkich zadań GitHub Actions. W przypadku niepowodzenia testów proces wdrożenia zostaje automatycznie wstrzymany.

Takie rozwiązanie zapewnia, że na środowisko produkcyjne trafiają jedynie poprawnie zweryfikowane wersje aplikacji.

## Implementacja zaplanowanych mechanizmów zapewniających bezpieczeństwo w praktyce

W projekcie zastosowano szereg mechanizmów bezpieczeństwa zgodnych z podejściami Secure by Design, Zero Trust oraz Privacy by Design.

### 1. Bezpieczeństwo danych w tranzycie i spoczynku
- Cała komunikacja z aplikacją odbywa się przez protokół HTTPS.
- Dane przesyłane pomiędzy klientem a serwerem są szyfrowane.
- Hasła użytkowników są przechowywane w formie haszowanej (bcrypt).

### 2. Autoryzacja i uwierzytelnianie
- System wykorzystuje mechanizm logowania oparty o Laravel Authentication.
- Dostęp do zasobów jest kontrolowany przez role użytkowników (np. administrator, użytkownik).
- Zastosowano zasadę najmniejszych uprawnień (Least Privilege).

### 3. Ochrona przed atakami
- Laravel automatycznie zabezpiecza aplikację przed SQL Injection poprzez ORM Eloquent.
- Zastosowano ochronę CSRF dla formularzy.
- Walidacja danych wejściowych odbywa się po stronie serwera.

### 4. Bezpieczeństwo infrastruktury
- Środowisko produkcyjne hostowane jest na platformie Railway.
- Dane konfiguracyjne (np. dostęp do bazy danych) przechowywane są w zmiennych środowiskowych, a nie w kodzie źródłowym.
- Dostęp do bazy danych jest ograniczony tylko do usług wewnętrznych aplikacji.

### 5. CI/CD i bezpieczeństwo wdrożeń
- Wdrożenie aplikacji następuje wyłącznie po pomyślnym przejściu testów w GitHub Actions.
- Każda zmiana w gałęzi `main` przechodzi proces weryfikacji (Continuous Integration).
- Mechanizm Railway "Wait for CI" blokuje wdrożenie w przypadku błędów testów.

### 6. Ochrona danych użytkownika (Privacy by Design)
- System minimalizuje zakres przetwarzanych danych osobowych.
- Dane użytkowników są wykorzystywane wyłącznie w zakresie niezbędnym do realizacji rezerwacji.
- Brak przechowywania danych kart płatniczych w systemie.

# Dokumentacja użytkownika

## Spis treści

1. Wprowadzenie
2. Rejestracja i logowanie
3. Wyszukiwanie lotów
4. Proces rezerwacji lotu 
5. Zarządzanie rezerwacjami
6. Płatności
7. Generowanie biletu PDF
8. Panel użytkownika
9. Rozwiązywanie problemów

---

## 1. Wprowadzenie

System rezerwacji lotów umożliwia wyszukiwanie dostępnych połączeń lotniczych, tworzenie rezerwacji, zarządzanie pasażerami oraz generowanie biletów elektronicznych.

Aplikacja działa w przeglądarce internetowej i nie wymaga instalacji dodatkowego oprogramowania.

---

## 2. Rejestracja i logowanie

Użytkownik może założyć konto poprzez formularz rejestracyjny, podając:
- imię i nazwisko,
- adres e-mail,
- hasło.

Po rejestracji możliwe jest logowanie do systemu przy użyciu adresu e-mail i hasła.

---

## 3. Wyszukiwanie lotów

System umożliwia wyszukiwanie lotów na podstawie:
- lotniska wylotu,
- lotniska przylotu,
- daty podróży,
- liczby pasażerów.

Wyniki można filtrować oraz sortować według ceny i czasu lotu.

---

# 4. Proces rezerwacji lotu 

Proces rezerwacji rozpoczyna się po wybraniu konkretnego lotu z listy wyników wyszukiwania.

### Krok 1 – wybór lotu
Użytkownik klika przycisk „Zarezerwuj”, aby przejść do formularza rezerwacji.

### Krok 2 – dane pasażerów
Użytkownik wprowadza dane każdego pasażera:
- imię i nazwisko,
- data urodzenia,
- obywatelstwo,
- numer dokumentu.

System umożliwia dodanie wielu pasażerów w jednej rezerwacji.

### Krok 3 – dane kontaktowe
Wymagane jest podanie:
- adresu e-mail,
- numeru telefonu.

### Krok 4 – podsumowanie
System wyświetla:
- szczegóły lotu,
- listę pasażerów,
- całkowity koszt rezerwacji.

### Krok 5 – potwierdzenie
Użytkownik zatwierdza rezerwację i przechodzi do płatności.

---

# 5. Zarządzanie rezerwacjami 

W panelu użytkownika dostępna jest lista wszystkich rezerwacji.

### Dostępne operacje:
- podgląd szczegółów rezerwacji,
- anulowanie rezerwacji,
- sprawdzenie statusu płatności,
- pobranie biletu PDF.

### Statusy rezerwacji:
- `pending` – oczekuje,
- `awaiting_payment` – oczekuje na płatność,
- `paid` – opłacona,
- `cancelled` – anulowana.

### Anulowanie rezerwacji
Użytkownik może anulować rezerwację, jeśli nie została jeszcze wykorzystana. System może naliczyć opłatę zgodnie z warunkami taryfy.

---

## 6. Płatności

System obsługuje proces płatności dla rezerwacji. Po dokonaniu płatności status rezerwacji zmienia się na `paid`.

---

## 7. Generowanie biletu PDF

Po opłaceniu rezerwacji użytkownik może wygenerować bilet w formacie PDF zawierający:
- dane pasażera,
- numer rezerwacji,
- szczegóły lotu.

---

## 8. Panel użytkownika

Panel użytkownika umożliwia:
- edycję danych konta,
- przegląd historii rezerwacji,
- pobieranie dokumentów.

---

## 9. Rozwiązywanie problemów

W przypadku problemów:
- sprawdź poprawność danych logowania,
- upewnij się, że rezerwacja została opłacona,
- odśwież stronę lub spróbuj ponownie później.
