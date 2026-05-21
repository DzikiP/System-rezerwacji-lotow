# SYSTEM ZARZĄDZANIA REZERWACJĄ LOTÓW
## 1. CEL PROJEKTU

Celem projektu jest stworzenie internetowego systemu rezerwacji biletów lotniczych w technologii Laravel, umożliwiającego użytkownikom wyszukiwanie lotów, rezerwację miejsc oraz realizację płatności online.

System zostanie zrealizowany jako monolityczna aplikacja webowa (Blade + Laravel API), co umożliwia szybkie wdrożenie i uproszczony deployment (np. Render / Railway / VPS).

Projekt ma na celu:

automatyzację procesu rezerwacji lotów,
uproszczenie zakupu biletów,
zapewnienie podstawowego panelu użytkownika i administratora,
integrację z zewnętrznym API lotów i jedną bramką płatności. 
## 2. OPIS SYSTEMU – WYMAGANIA FUNKCJONALNE
   ### 2.1 Rejestracja i logowanie 

System wykorzystuje wbudowany mechanizm autoryzacji Laravel:

rejestracja użytkownika (email + hasło),
logowanie / wylogowanie,
hasła szyfrowane (bcrypt),
weryfikacja email (Laravel notifications),
role użytkowników (Spatie Permission):
user
admin

### 2.2 Wyszukiwanie lotów (Flight Search API)

System umożliwia wyszukiwanie lotów poprzez:

integrację z zewnętrznym API (np. Amadeus / Aviationstack / mock API),
filtrowanie:
lotnisko wylotu (IATA)
lotnisko przylotu
data wylotu
liczba pasażerów
cache wyników (Redis / Laravel Cache)
#### 2.3 Implementacja:

Laravel Service FlightService
HTTP Client (Http::get())

### 2.4 Szczegóły lotu

Po wybraniu lotu użytkownik widzi:

przewoźnika
czas lotu
trasę
cenę
warunki (bagaż, refundacja – jeśli API zwraca)
przycisk „Rezerwuj”

### 2.5 Rezerwacja

Proces rezerwacji:

formularz pasażera:
imię, nazwisko
data urodzenia
dokument
dane kontaktowe
zapis do tabel:
bookings
passengers

Walidacja:

max 6 pasażerów
1 niemowlę / dorosły

Status:

pending
awaiting_payment
paid
cancelled
### 2.6 Płatności 

Integracja z jedną bramką:

Stripe Checkout 
lub
Przelewy24 

Flow:

użytkownik tworzy rezerwację
system generuje payment session
webhook aktualizuje status

Laravel:

PaymentController
Stripe Webhook Controller

### 2.7 Potwierdzenie rezerwacji

Po płatności:

generowanie PDF biletu (dompdf / laravel-pdf)
wysyłka email (Laravel Mail)
dostęp w panelu użytkownika

### 2.8 Panel użytkownika

Użytkownik może:

przeglądać rezerwacje
pobierać bilety PDF
anulować rezerwację (jeśli allowed)
edytować dane konta

### 2.9 Zakres MVP (OGROMNE CIĘCIE FUNKCJI)

W wersji Laravel MVP NIE IMPLEMENTUJEMY:

2FA
dynamic seat map (tylko wybór „A1–C10” statyczny)
multi API provider
SMS (opcjonalnie później)
real-time flight tracking
mikroserwisy
React frontend

UI = Blade + Tailwind

### 2.9 Integracje

Flight API (1 provider)
Email (SMTP / Mailtrap)
Payment (Stripe / P24)

## 3. OPIS SYSTEMU – WYMAGANIA NIEFUNKCJONALNE (Laravel)
   ### 3.1 Architektura
   Laravel monolith
   Blade + Tailwind CSS
   MySQL / PostgreSQL
   Redis cache (opcjonalnie)
   ### 3.2 API

REST API (dla przyszłości):

/api/flights/search
/api/bookings
/api/payments/webhook

### 3.3 Wydajność
cache wyników lotów
pagination zamiast infinite scroll
queue (Laravel Queue) dla:
emaili
PDF generacji

### 3.4 Bezpieczeństwo

Laravel built-in:

CSRF protection
hashed passwords
middleware auth
rate limiting
validation rules

### 3.5 Niezawodność
queue retry system
logi Laravel (Monolog)
backup DB (cron)

### 3.6 Deployment (kluczowe)

Najprościej:

Render / Railway / VPS
PHP 8.3+
Composer install
ENV config
storage link
queue worker
cron scheduler

## 4. OGRANICZENIA
   Technologiczne
   tylko Laravel monolith
   tylko 1 API lotów
   tylko 1 payment provider
   brak mikroserwisów
   Czasowe
   2–3 tygodnie
   Budżetowe
   darmowe API (mock / sandbox)
   Stripe test mode

## 5. UŻYTKOWNICY
   User (pasażer)
   Admin
   pracownicy linii lotniczych

## 6. KLUCZOWE MODELE (Laravel)

Minimalny schemat:

users
flights (cache / external)
bookings
passengers
payments

## 7. NAJWAŻNIEJSZE PRZYPADKI UŻYCIA
* rejestracja / logowanie
* wyszukiwanie lotów
* wybór lotu
* rezerwacja
* płatność
* generowanie biletu PDF
* panel użytkownika
