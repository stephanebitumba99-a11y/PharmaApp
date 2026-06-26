import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class PharmacienService {

  private api = 'http://127.0.0.1:8000/api/pharmaciens';

  constructor(private http: HttpClient) {}

  // 🔥 GET ALL (SANS PAGINATION)
  getPharmaciens() {
    return this.http.get(this.api);
  }

  // 🔥 DELETE
  deletePharmacien(id: number) {
    return this.http.delete(`${this.api}/${id}`);
  }
}