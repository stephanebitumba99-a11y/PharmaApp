import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { PharmaForm } from '../../models/pharmaform/pharmaform-module';

@Injectable({
  providedIn: 'root'
})
export class PharmaformService {

  private api = 'http://127.0.0.1:8000/api/pharmaciens';

  constructor(private http: HttpClient) {}

  // ➕ CREATE PHARMACIEN
  createPharmacien(data: PharmaForm) {
    return this.http.post(this.api, data);
  }
}