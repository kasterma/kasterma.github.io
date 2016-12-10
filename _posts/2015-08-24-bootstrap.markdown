---
layout: post
title: bootstrap on aggregated data
---

If you have a data where ech row represents a separate observation then
getting a bootstrap sample from it is just

    sample(data, replace = TRUE)

If your data is aggregated so that every row represents many observations
with a count column to indicate the number of observations, then the
following function gives you a bootstrap sample

    agg_bootstrap <- function(dat, cts_colname) {
      cts <- dat[[cts_colname]]
      # do the bootstrap sampling
      idxs <- sample(seq_along(cts), prob = cts, size = sum(cts), replace = TRUE)
      # aggregate results of sampling
      idx_ct <- tabulate(idxs, nbins = nrow(dat))
      # add bookstrap column and set values
      dat[[paste0(cts_colname, "bootstrap")]] <- idx_ct
    }