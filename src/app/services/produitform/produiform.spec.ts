import { TestBed } from '@angular/core/testing';

import { Produiform } from './produiform';

describe('Produiform', () => {
  let service: Produiform;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(Produiform);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
