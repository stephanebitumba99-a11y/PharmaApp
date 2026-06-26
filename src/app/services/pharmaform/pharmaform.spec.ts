import { TestBed } from '@angular/core/testing';

import { Pharmaform } from './pharmaform';

describe('Pharmaform', () => {
  let service: Pharmaform;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Pharmaform);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
