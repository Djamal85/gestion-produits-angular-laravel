import { HttpClient } from '@angular/common/http';
import { computed, inject, Injectable, signal } from '@angular/core';
import { tap } from 'rxjs';

interface AuthResponse {
  token: string;
  user: { id: number; name: string; email: string };
}

@Injectable({ providedIn: 'root' })
export class AuthService {
  private readonly http = inject(HttpClient);
  private readonly apiUrl = 'http://localhost:8000/api';
  private readonly tokenState = signal(localStorage.getItem('auth_token'));

  readonly isAuthenticated = computed(() => Boolean(this.tokenState()));

  get token(): string | null {
    return this.tokenState();
  }

  login(credentials: { email: string; password: string }) {
    return this.http
      .post<AuthResponse>(`${this.apiUrl}/login`, credentials)
      .pipe(tap((response) => this.saveToken(response.token)));
  }

  register(payload: {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
  }) {
    return this.http
      .post<AuthResponse>(`${this.apiUrl}/register`, payload)
      .pipe(tap((response) => this.saveToken(response.token)));
  }

  logout() {
    return this.http
      .post(`${this.apiUrl}/logout`, {})
      .pipe(tap(() => this.clearToken()));
  }

  clearToken(): void {
    localStorage.removeItem('auth_token');
    this.tokenState.set(null);
  }

  private saveToken(token: string): void {
    localStorage.setItem('auth_token', token);
    this.tokenState.set(token);
  }
}
