CREATE TABLE nfn_fiche_likes (
  user_id INT NOT NULL,
  fiche_id INT NOT NULL,
  PRIMARY KEY(user_id, fiche_id)
);
