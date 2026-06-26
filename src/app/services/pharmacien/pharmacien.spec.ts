import { TestBed } from '@angular/core/testing';

import { Pharmacien } from './pharmacien';

describe('Pharmacien', () => {
  let service: Pharmacien;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Pharmacien);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
