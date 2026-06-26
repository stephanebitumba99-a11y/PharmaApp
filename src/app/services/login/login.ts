import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class LoginService {

  private baseUrl = 'http://127.0.0.1:8000/api/auth/login';

  constructor(private http: HttpClient) {}

  login(data: any) {
    return this.http.post(this.baseUrl, data);
  }
}